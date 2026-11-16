<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;
use App\Core\View;
use App\Models\OtpCode;
use App\Models\Setting;
use App\Services\SmsService;

class HomeController
{
    public function index(): void
    {
        $priceDefault = (int)Setting::get('price_default_cip', '2500000');
        $priceCustom = (int)Setting::get('price_custom_design', '5000000');
        $siteTitle = Setting::get('site_title', 'CIPCard | کارت ویزیت هوشمند NFC لوکس');

        View::render('home.index', [
            'title'        => $siteTitle,
            'priceDefault' => $priceDefault,
            'priceCustom'  => $priceCustom
        ], 'main');
    }

    /**
     * Step 1 of User Flow: Process Fast Order Form Submission from Landing Page
     */
    public function fastOrder(): void
    {
        Csrf::verifyOrAbort();

        $fullName  = trim($_POST['full_name'] ?? '');
        $jobTitle  = trim($_POST['job_title'] ?? '');
        $rawMobile = trim($_POST['mobile'] ?? '');
        $cardType  = trim($_POST['card_type'] ?? 'default_cip');
        $template  = trim($_POST['template_id'] ?? 'minimal');
        $themeColor= trim($_POST['theme_color'] ?? 'gold_black');

        // Basic social links
        $social = [
            'instagram' => trim($_POST['instagram'] ?? ''),
            'whatsapp'  => trim($_POST['whatsapp'] ?? ''),
            'telegram'  => trim($_POST['telegram'] ?? ''),
            'linkedin'  => trim($_POST['linkedin'] ?? ''),
            'website'   => trim($_POST['website'] ?? '')
        ];

        // Validation
        if (empty($fullName) || empty($rawMobile)) {
            Helper::jsonResponse(['success' => false, 'message' => 'لطفاً نام و نام خانوادگی و شماره موبایل را وارد کنید.'], 422);
        }

        $mobile = Helper::normalizeMobile($rawMobile);
        if (!$mobile) {
            Helper::jsonResponse(['success' => false, 'message' => 'فرمت شماره موبایل نامعتبر است. شماره باید با 09 شروع شود.'], 422);
        }

        if (!in_array($cardType, ['default_cip', 'custom_design'], true)) {
            $cardType = 'default_cip';
        }

        $priceKey = ($cardType === 'custom_design') ? 'price_custom_design' : 'price_default_cip';
        $defaultPrice = ($cardType === 'custom_design') ? 5000000 : 2500000;
        $amount = (int)Setting::get($priceKey, (string)$defaultPrice);

        // Store pre-order state in Session
        Session::start();
        Session::set('pending_order', [
            'full_name'   => $fullName,
            'job_title'   => $jobTitle,
            'mobile'      => $mobile,
            'card_type'   => $cardType,
            'amount'      => $amount,
            'template_id' => $template,
            'theme_color' => $themeColor,
            'social_links'=> $social
        ]);

        // Step 2: Generate and dispatch OTP
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $otpCode = OtpCode::generate($mobile, $ip);
        $smsSent = SmsService::sendOtp($mobile, $otpCode);

        // In sandbox or testing mode, log the OTP for development convenience
        error_log("CIPCard OTP for {$mobile}: {$otpCode}");

        Helper::jsonResponse([
            'success' => true,
            'step'    => 'otp_verification',
            'mobile'  => $mobile,
            'message' => 'کد تایید با موفقیت به شماره موبایل شما ارسال شد.'
        ]);
    }
}
