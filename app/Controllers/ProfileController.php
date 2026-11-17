<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helper;
use App\Core\View;
use App\Models\Profile;
use App\Services\QrCodeService;
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

        View::render($viewName, [
            'title'         => $profile['display_name'] . ' - کارت ویزیت هوشمند CIPCard',
            'profile'       => $profile,
            'profileUrl'    => $profileUrl,
            'qrCodeDataUri' => $qrCodeDataUri
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
     * Direct SVG QR Code Endpoint
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
        QrCodeService::renderSvgResponse($profileUrl, 320);
    }
}
