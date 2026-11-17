<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;
use App\Core\View;
use App\Models\Order;
use App\Models\OtpCode;
use App\Models\Profile;
use App\Models\Transaction;
use App\Models\User;
use App\Services\SmsService;
use App\Services\ZarinpalService;

class AuthController
{
    public function showLogin(): void
    {
        Session::start();
        if (Session::has('user_id')) {
            Helper::redirect('dashboard');
        }

        View::render('auth.login', ['title' => 'ورود به حساب کاربری - CIPCard'], 'main');
    }

    public function sendOtp(): void
    {
        Csrf::verifyOrAbort();

        $rawMobile = trim($_POST['mobile'] ?? '');
        $mobile = Helper::normalizeMobile($rawMobile);

        if (!$mobile) {
            Helper::jsonResponse(['success' => false, 'message' => 'شماره موبایل وارد شده معتبر نیست.'], 422);
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $code = OtpCode::generate($mobile, $ip);
        SmsService::sendOtp($mobile, $code);

        error_log("CIPCard OTP for {$mobile}: {$code}");

        Helper::jsonResponse([
            'success' => true,
            'mobile'  => $mobile,
            'message' => 'کد تایید پیامک شد.'
        ]);
    }

    /**
     * Step 2 & 3: Verify OTP, create account, set login session, & redirect to Zarinpal or Dashboard
     */
    public function verifyOtp(): void
    {
        Csrf::verifyOrAbort();

        $rawMobile = trim($_POST['mobile'] ?? '');
        $code = trim($_POST['code'] ?? '');

        $mobile = Helper::normalizeMobile($rawMobile);
        if (!$mobile || empty($code)) {
            Helper::jsonResponse(['success' => false, 'message' => 'لطفاً کد تایید و شماره موبایل را وارد کنید.'], 422);
        }

        if (!OtpCode::verify($mobile, $code)) {
            Helper::jsonResponse(['success' => false, 'message' => 'کد تایید اشتباه است یا منقضی شده است.'], 400);
        }

        // OTP verified successfully. Find or create user.
        $user = User::findByMobile($mobile);
        $pendingOrder = Session::get('pending_order');

        if (!$user) {
            $fullName = $pendingOrder['full_name'] ?? ('کاربر ' . substr($mobile, -4));
            $userId = User::create([
                'mobile'    => $mobile,
                'full_name' => $fullName,
                'role'      => 'user',
                'status'    => 'active'
            ]);
            $user = User::findById($userId);
        } else {
            // Activate user if was pending
            if ($user['status'] === 'pending_verification') {
                User::update((int)$user['id'], ['status' => 'active']);
            }
        }

        // Establish User Session
        Session::regenerate();
        Session::set('user_id', (int)$user['id']);
        Session::set('user_role', $user['role']);
        Session::set('user_name', $user['full_name']);
        Session::set('user_mobile', $user['mobile']);

        // Check if there is a pending order from landing page (Flow Step 3)
        if ($pendingOrder && $pendingOrder['mobile'] === $mobile) {
            // 1. Create or update profile
            $existingProfile = Profile::findByUserId((int)$user['id']);
            if (!$existingProfile) {
                Profile::create([
                    'user_id'      => (int)$user['id'],
                    'display_name' => $pendingOrder['full_name'],
                    'job_title'    => $pendingOrder['job_title'],
                    'phone_mobile' => $mobile,
                    'social_links' => $pendingOrder['social_links'],
                    'template_id'  => $pendingOrder['template_id'],
                    'theme_color'  => $pendingOrder['theme_color'],
                    'is_active'    => 0 // Activates after payment
                ]);
            }

            // 2. Create Order in DB
            $orderId = Order::create([
                'user_id'   => (int)$user['id'],
                'card_type' => $pendingOrder['card_type'],
                'amount'    => $pendingOrder['amount'],
                'status'    => 'unpaid'
            ]);

            $order = Order::findById($orderId);

            // Clear session pending order
            Session::remove('pending_order');

            // 3. Initiate Zarinpal Payment
            $zarinpal = new ZarinpalService();
            $callbackUrl = Helper::url('payment/callback');
            $description = "سفارش کارت هوشمند CIPCard - شماره: {$order['order_number']}";

            $payResult = $zarinpal->requestPayment(
                (int)$order['amount'],
                $description,
                $callbackUrl,
                $mobile,
                null
            );

            if ($payResult['success'] && !empty($payResult['authority'])) {
                // Record pending transaction
                Transaction::create([
                    'order_id'  => $orderId,
                    'user_id'   => (int)$user['id'],
                    'authority' => $payResult['authority'],
                    'amount'    => (int)$order['amount'],
                    'gateway'   => 'zarinpal',
                    'status'    => 'pending'
                ]);

                $redirectUrl = $zarinpal->getStartPayUrl($payResult['authority']);
                Helper::jsonResponse([
                    'success'  => true,
                    'redirect' => $redirectUrl,
                    'message'  => 'در حال انتقال به درگاه امن زرین‌پال...'
                ]);
            } else {
                // If Zarinpal request failed, send to dashboard with message to retry
                Session::setFlash('warning', 'سفارش شما ثبت شد اما در اتصال به درگاه خطایی رخ داد: ' . ($payResult['message'] ?? ''));
                Helper::jsonResponse([
                    'success'  => true,
                    'redirect' => Helper::url('dashboard'),
                    'message'  => 'سفارش ثبت شد. هدایت به داشبورد...'
                ]);
            }
        }

        // Standard Login without pending order
        Helper::jsonResponse([
            'success'  => true,
            'redirect' => Helper::url('dashboard'),
            'message'  => 'ورود با موفقیت انجام شد.'
        ]);
    }

    public function showAdminLogin(): void
    {
        Session::start();
        if (Session::has('user_id') && Session::get('user_role') === 'admin') {
            Helper::redirect('admin');
        }

        View::render('admin.login', ['title' => 'ورود مدیریت - CIPCard'], null);
    }

    public function adminLoginSubmit(): void
    {
        Csrf::verifyOrAbort();

        $rawUsername = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $user = User::findByUsernameOrMobile($rawUsername);

        if (!$user || $user['role'] !== 'admin' || empty($user['password']) || !password_verify($password, $user['password'])) {
            Session::setFlash('error', 'نام کاربری یا رمز عبور اشتباه است.');
            Helper::redirect('admin/login');
        }

        Session::regenerate();
        Session::set('user_id', (int)$user['id']);
        Session::set('user_role', 'admin');
        Session::set('user_name', $user['full_name']);
        Session::set('user_mobile', $user['mobile']);

        Helper::redirect('admin');
    }

    public function logout(): void
    {
        Session::destroy();
        Helper::redirect('');
    }
}
