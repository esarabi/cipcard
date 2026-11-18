<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helper;
use App\Core\View;
use App\Models\Profile;
use App\Models\Review;
use App\Services\QrCodeService;
use App\Services\TranslationService;
use App\Services\VCardService;

class ProfileController
{
    /**
     * Display Public NFC Smart Profile: cipcard.ir/@09123456789
     */
    public function show(string $mobile): void
    {
        $normalizedMobile = Helper::normalizeMobile($mobile);
        $profile = Profile::findByMobile($normalizedMobile ?: $mobile);

        if (!$profile) {
            http_response_code(404);
            View::render('home.404', ['title' => 'پروفایل یافت نشد - CIPCard'], 'main');
            return;
        }

        // Security / Business rule: If unpaid / not activated, show pending activation screen
        if ((int)$profile['is_active'] !== 1) {
            View::render('profile.pending', [
                'title'   => 'پروفایل در انتظار فعال‌سازی - CIPCard',
                'profile' => $profile
            ], null);
            return;
        }

        // Multi-Language resolution (6 languages supported: fa, en, ar, tr, ru, zh)
        $currentLang = TranslationService::sanitizeLang($_GET['lang'] ?? $profile['default_lang'] ?? 'fa');
        $langDir = TranslationService::getDirection($currentLang);
        $translations = TranslationService::getAll($currentLang);
        $supportedLangs = TranslationService::getSupportedLanguages();

        // Increment visit counter
        Profile::incrementViews((int)$profile['id']);

        // Generate profile URL & QR code Data URI
        $profileIdentifier = !empty($profile['slug']) ? $profile['slug'] : $profile['mobile'];
        $profileUrl = Helper::url('@' . $profileIdentifier);
        $qrCodeDataUri = QrCodeService::getDataUri($profileUrl, 260);

        $template = $profile['template_id'] ?? 'minimal';
        $validTemplates = ['minimal', 'glassmorphism', 'corporate', 'creative_dark', 'modern_card'];
        if (!in_array($template, $validTemplates, true)) {
            $template = 'minimal';
        }

        $viewName = "profile.templates.{$template}";

        // Reviews & Rating System
        $enableReviews = !isset($profile['enable_reviews']) || (int)$profile['enable_reviews'] === 1;
        $reviews = [];
        $reviewStats = [
            'total_reviews'  => 0,
            'average_rating' => 5.0,
            'star_counts'    => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]
        ];

        if ($enableReviews) {
            $reviews = Review::getApprovedByProfileId((int)$profile['id']);
            $reviewStats = Review::getStatsByProfileId((int)$profile['id']);
        }

        View::render($viewName, [
            'title'          => $profile['display_name'] . ' - ' . ($translations['card_title'] ?? 'کارت ویزیت هوشمند CIPCard'),
            'profile'        => $profile,
            'profileUrl'     => $profileUrl,
            'qrCodeDataUri'  => $qrCodeDataUri,
            'currentLang'    => $currentLang,
            'langDir'        => $langDir,
            'translations'   => $translations,
            'supportedLangs' => $supportedLangs,
            'enableReviews'  => $enableReviews,
            'reviews'        => $reviews,
            'reviewStats'    => $reviewStats
        ], null);
    }

    /**
     * Download vCard .vcf File
     */
    public function vcard(string $mobile): void
    {
        $normalizedMobile = Helper::normalizeMobile($mobile);
        $profile = Profile::findByMobile($normalizedMobile ?: $mobile);

        if (!$profile || (int)$profile['is_active'] !== 1) {
            http_response_code(404);
            die('پروفایل یافت نشد یا هنوز فعال نشده است.');
        }

        VCardService::download($profile);
    }

    /**
     * Direct QR Code Image Endpoint (PNG)
     */
    public function qr(string $mobile): void
    {
        $normalizedMobile = Helper::normalizeMobile($mobile);
        $profile = Profile::findByMobile($normalizedMobile ?: $mobile);

        if (!$profile) {
            http_response_code(404);
            exit;
        }

        $profileIdentifier = !empty($profile['slug']) ? $profile['slug'] : $profile['mobile'];
        $profileUrl = Helper::url('@' . $profileIdentifier);
        QrCodeService::renderPngResponse($profileUrl, 360);
    }

    /**
     * Submit a new visitor review & star rating
     */
    public function submitReview(string $mobile): void
    {
        $normalizedMobile = Helper::normalizeMobile($mobile);
        $profile = Profile::findByMobile($normalizedMobile ?: $mobile);

        $isJson = isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')
            || (isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'application/json'));

        if (!$profile || (int)$profile['is_active'] !== 1) {
            http_response_code(404);
            if ($isJson) {
                echo json_encode(['success' => false, 'message' => 'پروفایل مورد نظر یافت نشد.'], JSON_UNESCAPED_UNICODE);
                return;
            }
            Helper::redirect('');
            return;
        }

        // Check if reviews are enabled for this profile
        if (isset($profile['enable_reviews']) && (int)$profile['enable_reviews'] === 0) {
            http_response_code(403);
            if ($isJson) {
                echo json_encode(['success' => false, 'message' => 'امکان ثبت نظر برای این پروفایل غیرفعال است.'], JSON_UNESCAPED_UNICODE);
                return;
            }
            Helper::redirect('@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile']));
            return;
        }

        // Simple anti-spam throttle: 1 review per 30 seconds per session
        $now = time();
        if (isset($_SESSION['last_review_submission']) && ($now - (int)$_SESSION['last_review_submission']) < 20) {
            http_response_code(429);
            $msg = 'لطفاً کمی صبر کرده و سپس مجدداً تلاش فرمایید.';
            if ($isJson) {
                echo json_encode(['success' => false, 'message' => $msg], JSON_UNESCAPED_UNICODE);
                return;
            }
            Helper::redirect('@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile']));
            return;
        }

        // Parse input
        $authorName   = trim($_POST['author_name'] ?? '');
        $authorMobile = trim($_POST['author_mobile'] ?? '');
        $rating       = (int)($_POST['rating'] ?? 5);
        $comment      = trim($_POST['comment'] ?? '');

        if (mb_strlen($authorName) < 2) {
            http_response_code(422);
            $msg = 'لطفاً نام و نام خانوادگی خود را وارد کنید.';
            if ($isJson) {
                echo json_encode(['success' => false, 'message' => $msg], JSON_UNESCAPED_UNICODE);
                return;
            }
            Helper::redirect('@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile']));
            return;
        }

        if (mb_strlen($comment) < 3) {
            http_response_code(422);
            $msg = 'لطفاً متن نظر خود را به صورت کامل وارد فرمایید.';
            if ($isJson) {
                echo json_encode(['success' => false, 'message' => $msg], JSON_UNESCAPED_UNICODE);
                return;
            }
            Helper::redirect('@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile']));
            return;
        }

        if ($rating < 1 || $rating > 5) {
            $rating = 5;
        }

        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;

        // Insert review (status = 'pending')
        Review::create([
            'profile_id'    => (int)$profile['id'],
            'author_name'   => $authorName,
            'author_mobile' => $authorMobile ?: null,
            'rating'        => $rating,
            'comment'       => $comment,
            'ip_address'    => $ipAddress
        ]);

        $_SESSION['last_review_submission'] = $now;

        $successMsg = 'نظر و امتیاز شما با موفقیت ثبت شد و پس از بررسی و تایید توسط صاحب کارت ویزیت نمایش داده خواهد شد. با تشکر!';

        if ($isJson) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => true, 'message' => $successMsg], JSON_UNESCAPED_UNICODE);
            return;
        }

        \App\Core\Session::setFlash('review_success', $successMsg);
        Helper::redirect('@' . (!empty($profile['slug']) ? $profile['slug'] : $profile['mobile']) . '#reviews');
    }

    /**
     * Submit review via generic endpoint with identifier in POST
     */
    public function submitReviewGeneric(): void
    {
        $identifier = trim($_POST['mobile'] ?? $_POST['slug'] ?? $_POST['profile_identifier'] ?? '');
        $this->submitReview($identifier);
    }
}
