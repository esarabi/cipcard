<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\Config;
use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;
use App\Core\View;
use App\Models\Order;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Services\QrCodeService;
use App\Services\TranslationService;
use App\Services\ZarinpalService;

class DashboardController
{
    private int $userId;

    public function __construct()
    {
        Session::start();
        $this->userId = (int)Session::get('user_id');
    }

    public function index(): void
    {
        $user = User::findById($this->userId);
        $profile = Profile::findByUserId($this->userId);
        $orders = Order::findByUserId($this->userId);
        $latestOrder = $orders[0] ?? null;

        $profileIdentifier = !empty($profile['slug']) ? $profile['slug'] : ($user['mobile'] ?? '');
        $profileUrl = $profile ? Helper::url('@' . $profileIdentifier) : '';
        $qrCodeDataUri = $profile ? QrCodeService::getDataUri($profileUrl, 240) : '';

        $priceDefault = (int)Setting::get('price_default_cip', '2500000');
        $priceCustom  = (int)Setting::get('price_custom_design', '5000000');

        View::render('user.dashboard', [
            'title'         => 'داشبورد کاربری - CIPCard',
            'user'          => $user,
            'profile'       => $profile,
            'orders'        => $orders,
            'latestOrder'   => $latestOrder,
            'profileUrl'    => $profileUrl,
            'qrCodeDataUri' => $qrCodeDataUri,
            'priceDefault'  => $priceDefault,
            'priceCustom'   => $priceCustom
        ], 'user');
    }

    public function editProfile(): void
    {
        $user = User::findById($this->userId);
        $profile = Profile::findByUserId($this->userId);
        $supportedLangs = TranslationService::getSupportedLanguages();

        View::render('user.edit_profile', [
            'title'          => 'ویرایش مشخصات پروفایل هوشمند - CIPCard',
            'user'           => $user,
            'profile'        => $profile,
            'supportedLangs' => $supportedLangs
        ], 'user');
    }

    public function updateProfile(): void
    {
        Csrf::verifyOrAbort();

        $displayName = trim($_POST['display_name'] ?? '');
        $jobTitle    = trim($_POST['job_title'] ?? '');
        $company     = trim($_POST['company'] ?? '');
        $bio         = trim($_POST['bio'] ?? '');
        $moreInfo    = trim($_POST['more_info'] ?? '');
        $moreInfoTitle = trim($_POST['more_info_title'] ?? '');
        $phoneMobile = trim($_POST['phone_mobile'] ?? '');
        $phoneWork   = trim($_POST['phone_work'] ?? '');
        $email       = trim($_POST['email'] ?? '');
        $website     = trim($_POST['website'] ?? '');
        $address     = trim($_POST['address'] ?? '');
        
        $currentProfile = Profile::findByUserId($this->userId);
        $templateId  = !empty($_POST['template_id']) ? trim($_POST['template_id']) : ($currentProfile['template_id'] ?? 'minimal');
        $validTemplates = ['minimal', 'glassmorphism', 'corporate', 'creative_dark', 'modern_card'];
        if (!in_array($templateId, $validTemplates, true)) {
            $templateId = $currentProfile['template_id'] ?? 'minimal';
        }

        $themeColor  = !empty($_POST['theme_color']) ? trim($_POST['theme_color']) : ($currentProfile['theme_color'] ?? 'gold_black');
        $themeMode   = !empty($_POST['theme_mode']) ? trim($_POST['theme_mode']) : ($currentProfile['theme_mode'] ?? 'light');

        // New profile attributes: slug, default_lang, map & working hours
        $rawSlug      = trim($_POST['slug'] ?? '');
        $defaultLang  = TranslationService::sanitizeLang($_POST['default_lang'] ?? 'fa');
        $mapLink      = trim($_POST['map_link'] ?? '');
        $mapLatitude  = trim($_POST['map_latitude'] ?? '');
        $mapLongitude = trim($_POST['map_longitude'] ?? '');
        $workingDays  = trim($_POST['working_days'] ?? '');
        $workingHours = trim($_POST['working_hours'] ?? '');
        $workingNote  = trim($_POST['working_note'] ?? '');

        // Iranian & International Social Networks
        $socialLinks = [
            'eitaa'     => trim($_POST['eitaa'] ?? ''),
            'bale'      => trim($_POST['bale'] ?? ''),
            'rubika'    => trim($_POST['rubika'] ?? ''),
            'soroush'   => trim($_POST['soroush'] ?? ''),
            'aparat'    => trim($_POST['aparat'] ?? ''),
            'instagram' => trim($_POST['instagram'] ?? ''),
            'whatsapp'  => trim($_POST['whatsapp'] ?? ''),
            'telegram'  => trim($_POST['telegram'] ?? ''),
            'linkedin'  => trim($_POST['linkedin'] ?? ''),
            'github'    => trim($_POST['github'] ?? ''),
            'twitter'   => trim($_POST['twitter'] ?? '')
        ];

        if (empty($displayName)) {
            Session::setFlash('error', 'وارد کردن نام و نام خانوادگی الزامی است.');
            Helper::redirect('dashboard/profile');
            return;
        }

        // Validate custom non-mobile slug (e.g. @holding, @dr_alavi)
        $cleanSlug = null;
        if ($rawSlug !== '') {
            $cleanSlug = strtolower(ltrim($rawSlug, '@'));
            if (!Profile::isSlugAvailable($cleanSlug, $this->userId)) {
                Session::setFlash('error', "شناسه کاربری «{$rawSlug}» غیرمجاز است یا قبلاً رزرو شده است. شناسه باید بین ۳ تا ۴۰ حرف انگلیسی یا عدد باشد.");
                Helper::redirect('dashboard/profile');
                return;
            }
        }

        $profileData = [
            'slug'          => $cleanSlug,
            'display_name'  => $displayName,
            'job_title'     => $jobTitle,
            'company'       => $company,
            'bio'           => $bio,
            'more_info'     => $moreInfo,
            'more_info_title' => $moreInfoTitle,
            'phone_mobile'  => $phoneMobile,
            'phone_work'    => $phoneWork,
            'email'         => $email,
            'website'       => $website,
            'address'       => $address,
            'map_link'      => $mapLink,
            'map_latitude'  => (is_numeric($mapLatitude) && (float)$mapLatitude != 0) ? (float)$mapLatitude : null,
            'map_longitude' => (is_numeric($mapLongitude) && (float)$mapLongitude != 0) ? (float)$mapLongitude : null,
            'working_days'  => $workingDays,
            'working_hours' => $workingHours,
            'working_note'  => $workingNote,
            'default_lang'  => $defaultLang,
            'template_id'   => $templateId,
            'theme_color'   => $themeColor,
            'theme_mode'    => in_array($themeMode, ['light', 'dark'], true) ? $themeMode : 'light',
            'enable_reviews'=> isset($_POST['enable_reviews']) ? 1 : 0,
            'social_links'  => $socialLinks
        ];

        // Handle Avatar Upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['avatar'];
            if ($file['size'] <= Config::MAX_FILE_SIZE) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    if (!is_dir(Config::UPLOAD_AVATARS)) {
                        mkdir(Config::UPLOAD_AVATARS, 0755, true);
                    }
                    $newFileName = 'avatar_' . $this->userId . '_' . time() . '.' . $ext;
                    $dest = Config::UPLOAD_AVATARS . $newFileName;
                    if (move_uploaded_file($file['tmp_name'], $dest)) {
                        $profileData['avatar_url'] = 'uploads/avatars/' . $newFileName;
                    }
                }
            }
        }

        // Handle Cover / Banner Image Upload
        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['cover'];
            if ($file['size'] <= Config::MAX_FILE_SIZE) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    if (!is_dir(Config::UPLOAD_COVERS)) {
                        mkdir(Config::UPLOAD_COVERS, 0755, true);
                    }
                    $newFileName = 'cover_' . $this->userId . '_' . time() . '.' . $ext;
                    $dest = Config::UPLOAD_COVERS . $newFileName;
                    if (move_uploaded_file($file['tmp_name'], $dest)) {
                        $profileData['cover_url'] = 'uploads/covers/' . $newFileName;
                    }
                }
            }
        } elseif (isset($_POST['remove_cover']) && $_POST['remove_cover'] === '1') {
            $profileData['cover_url'] = null;
        }

        Profile::updateByUserId($this->userId, $profileData);
        Session::setFlash('success', 'تغییرات مشخصات، توضیحات بیشتر، آدرس اختصاصی، شبکه‌های اجتماعی و ساعات کاری با موفقیت ذخیره شد.');
        Helper::redirect('dashboard/profile');
    }

    public function switchTemplate(): void
    {
        Csrf::verifyOrAbort();

        $templateId = trim($_POST['template_id'] ?? 'minimal');
        $themeColor = trim($_POST['theme_color'] ?? 'gold_black');
        $themeMode  = trim($_POST['theme_mode'] ?? 'light');

        Profile::updateByUserId($this->userId, [
            'template_id' => $templateId,
            'theme_color' => $themeColor,
            'theme_mode'  => in_array($themeMode, ['light', 'dark'], true) ? $themeMode : 'light'
        ]);

        Session::setFlash('success', 'قالب، پالت رنگی و تم نمایش (روشن/تاریک) با موفقیت به‌روزرسانی شد.');
        Helper::redirect('dashboard');
    }

    /**
     * Submit a New Smart Card Order from User Dashboard
     */
    public function newOrder(): void
    {
        Csrf::verifyOrAbort();

        $cardType = trim($_POST['card_type'] ?? 'default_cip');
        if (!in_array($cardType, ['default_cip', 'custom_design'], true)) {
            $cardType = 'default_cip';
        }

        $shippingAddress = trim($_POST['shipping_address'] ?? '');
        $postalCode      = trim($_POST['postal_code'] ?? '');
        $notes           = trim($_POST['custom_design_notes'] ?? '');

        $priceKey     = ($cardType === 'custom_design') ? 'price_custom_design' : 'price_default_cip';
        $defaultPrice = ($cardType === 'custom_design') ? 5000000 : 2500000;
        $amount       = (int)Setting::get($priceKey, (string)$defaultPrice);

        $designFilePath = null;
        if (isset($_FILES['design_file']) && $_FILES['design_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['design_file'];
            if ($file['size'] <= Config::MAX_FILE_SIZE) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp', 'pdf', 'zip', 'rar', 'ai', 'psd'];
                if (in_array($ext, $allowed, true)) {
                    if (!is_dir(Config::UPLOAD_DESIGNS)) {
                        mkdir(Config::UPLOAD_DESIGNS, 0755, true);
                    }
                    $fileName = 'design_' . $this->userId . '_' . time() . '.' . $ext;
                    if (move_uploaded_file($file['tmp_name'], Config::UPLOAD_DESIGNS . $fileName)) {
                        $designFilePath = 'uploads/designs/' . $fileName;
                    }
                }
            }
        }

        $orderId = Order::create([
            'user_id'             => $this->userId,
            'card_type'           => $cardType,
            'amount'              => $amount,
            'status'              => 'unpaid',
            'custom_design_file'  => $designFilePath,
            'custom_design_notes' => $notes,
            'shipping_address'    => $shippingAddress,
            'postal_code'         => $postalCode
        ]);

        $order = Order::findById($orderId);
        $user  = User::findById($this->userId);

        // Initiate payment through Zarinpal
        $zarinpal = new ZarinpalService();
        $callbackUrl = Helper::url('payment/callback');
        $description = "سفارش کارت هوشمند جدید CIPCard - شماره: {$order['order_number']}";

        $payResult = $zarinpal->requestPayment(
            (int)$order['amount'],
            $description,
            $callbackUrl,
            $user['mobile'] ?? null,
            null
        );

        if ($payResult['success'] && !empty($payResult['authority'])) {
            Transaction::create([
                'order_id'  => $orderId,
                'user_id'   => $this->userId,
                'authority' => $payResult['authority'],
                'amount'    => (int)$order['amount'],
                'gateway'   => 'zarinpal',
                'status'    => 'pending'
            ]);

            $startPayUrl = $zarinpal->getStartPayUrl($payResult['authority']);
            header("Location: {$startPayUrl}");
            exit;
        }

        Session::setFlash('info', "سفارش کارت هوشمند شما با شماره {$order['order_number']} با موفقیت ثبت شد. می‌توانید در بخش پیگیری سفارشات نسبت به پرداخت آن اقدام نمایید.");
        Helper::redirect('dashboard/tracking');
    }

    public function orderTracking(): void
    {
        $user   = User::findById($this->userId);
        $orders = Order::findByUserId($this->userId);

        $priceDefault = (int)Setting::get('price_default_cip', '2500000');
        $priceCustom  = (int)Setting::get('price_custom_design', '5000000');

        View::render('user.order_tracking', [
            'title'        => 'پیگیری وضعیت سفارشات - CIPCard',
            'user'         => $user,
            'orders'       => $orders,
            'priceDefault' => $priceDefault,
            'priceCustom'  => $priceCustom
        ], 'user');
    }

    /**
     * Reviews & Star Ratings Management
     */
    public function reviews(): void
    {
        $user    = User::findById($this->userId);
        $profile = Profile::findByUserId($this->userId);

        if (!$profile) {
            Session::setFlash('warning', 'لطفاً ابتدا اطلاعات پروفایل خود را تکمیل نمایید.');
            Helper::redirect('dashboard/profile');
            return;
        }

        $currentStatus = trim($_GET['status'] ?? 'all');
        if (!in_array($currentStatus, ['all', 'pending', 'approved', 'rejected'], true)) {
            $currentStatus = 'all';
        }

        $counts  = Review::getCountsByProfileId((int)$profile['id']);
        $stats   = Review::getStatsByProfileId((int)$profile['id']);
        $reviews = Review::getAllByProfileId((int)$profile['id'], $currentStatus !== 'all' ? $currentStatus : null);

        View::render('user.reviews', [
            'title'         => 'مدیریت نظرات و امتیازهای کارت - CIPCard',
            'user'          => $user,
            'profile'       => $profile,
            'reviews'       => $reviews,
            'counts'        => $counts,
            'stats'         => $stats,
            'currentStatus' => $currentStatus
        ], 'user');
    }

    /**
     * Update review status (approve or reject)
     */
    public function updateReviewStatus(): void
    {
        Csrf::verifyOrAbort();

        $profile = Profile::findByUserId($this->userId);
        if (!$profile) {
            Helper::redirect('dashboard');
            return;
        }

        $reviewId = (int)($_POST['review_id'] ?? 0);
        $newStatus = trim($_POST['status'] ?? '');

        if ($reviewId <= 0 || !in_array($newStatus, ['approved', 'rejected', 'pending'], true)) {
            Session::setFlash('error', 'درخواست نامعتبر است.');
            Helper::redirect('dashboard/reviews');
            return;
        }

        $success = Review::updateStatus($reviewId, (int)$profile['id'], $newStatus);

        if ($success) {
            $statusTitles = [
                'approved' => 'تایید و منتشر شد',
                'rejected' => 'رد شد و نمایش داده نخواهد شد',
                'pending'  => 'به حالت در انتظار بررسی بازگشت'
            ];
            Session::setFlash('success', "وضعیت نظر با موفقیت تغییر کرد ({$statusTitles[$newStatus]}).");
        } else {
            Session::setFlash('error', 'خطا در تغییر وضعیت نظر.');
        }

        Helper::redirect('dashboard/reviews');
    }

    /**
     * Reply to a review
     */
    public function replyReview(): void
    {
        Csrf::verifyOrAbort();

        $profile = Profile::findByUserId($this->userId);
        if (!$profile) {
            Helper::redirect('dashboard');
            return;
        }

        $reviewId = (int)($_POST['review_id'] ?? 0);
        $replyText = trim($_POST['reply'] ?? '');

        if ($reviewId <= 0) {
            Session::setFlash('error', 'شناسه نظر نامعتبر است.');
            Helper::redirect('dashboard/reviews');
            return;
        }

        $success = Review::saveReply($reviewId, (int)$profile['id'], $replyText);

        if ($success) {
            if ($replyText !== '') {
                Session::setFlash('success', 'پاسخ شما با موفقیت ثبت شد و در زیر نظر مخاطب نمایش داده خواهد شد.');
            } else {
                Session::setFlash('info', 'پاسخ قبلی حذف شد.');
            }
        } else {
            Session::setFlash('error', 'خطا در ذخیره پاسخ.');
        }

        Helper::redirect('dashboard/reviews');
    }

    /**
     * Delete a review
     */
    public function deleteReview(): void
    {
        Csrf::verifyOrAbort();

        $profile = Profile::findByUserId($this->userId);
        if (!$profile) {
            Helper::redirect('dashboard');
            return;
        }

        $reviewId = (int)($_POST['review_id'] ?? 0);
        if ($reviewId <= 0) {
            Session::setFlash('error', 'شناسه نظر نامعتبر است.');
            Helper::redirect('dashboard/reviews');
            return;
        }

        $success = Review::delete($reviewId, (int)$profile['id']);

        if ($success) {
            Session::setFlash('success', 'نظر با موفقیت حذف گردید.');
        } else {
            Session::setFlash('error', 'خطا در حذف نظر.');
        }

        Helper::redirect('dashboard/reviews');
    }
}
