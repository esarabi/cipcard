<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;
use App\Core\View;
use App\Models\Order;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;

class AdminController
{
    public function dashboard(): void
    {
        $totalRevenue = Order::getTotalRevenue();
        $monthlyRevenue = Order::getMonthlyRevenue();
        $totalOrders = Order::countAll();
        $pendingOrders = Order::countAll('pending_design') + Order::countAll('printing');
        $totalUsers = User::countAll();

        $recentOrders = Order::getAllWithDetails(10, 0);
        $chartData = Transaction::getChartDataLast30Days();

        View::render('admin.dashboard', [
            'title'          => 'داشبورد مدیریت - CIPCard',
            'totalRevenue'   => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'totalOrders'    => $totalOrders,
            'pendingOrders'  => $pendingOrders,
            'totalUsers'     => $totalUsers,
            'recentOrders'   => $recentOrders,
            'chartData'      => $chartData
        ], 'admin');
    }

    public function orders(): void
    {
        $statusFilter = trim($_GET['status'] ?? '');
        $statusFilter = $statusFilter !== '' ? $statusFilter : null;

        $orders = Order::getAllWithDetails(50, 0, $statusFilter);

        View::render('admin.orders', [
            'title'        => 'مدیریت سفارشات - CIPCard',
            'orders'       => $orders,
            'statusFilter' => $statusFilter
        ], 'admin');
    }

    public function updateOrderStatus(): void
    {
        Csrf::verifyOrAbort();

        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');
        $trackingCode = trim($_POST['tracking_code'] ?? '');

        if ($orderId > 0 && !empty($status)) {
            Order::updateStatus($orderId, $status, !empty($trackingCode) ? $trackingCode : null);
            Session::setFlash('success', 'وضعیت سفارش با موفقیت بروزرسانی شد.');
        }

        Helper::redirect('admin/orders');
    }

    public function users(): void
    {
        $search = trim($_GET['q'] ?? '');
        if (!empty($search)) {
            $users = User::search($search);
        } else {
            $users = User::getAll(100, 0);
        }

        View::render('admin.users', [
            'title'  => 'مدیریت کاربران - CIPCard',
            'users'  => $users,
            'search' => $search
        ], 'admin');
    }

    public function editUser(string $id): void
    {
        $userId = (int)$id;
        $user = User::findById($userId);
        if (!$user) {
            Session::setFlash('error', 'کاربر یافت نشد.');
            Helper::redirect('admin/users');
        }

        $profile = Profile::findByUserId($userId);

        View::render('admin.user_edit', [
            'title'   => 'ویرایش مشخصات کاربر - ' . $user['full_name'],
            'user'    => $user,
            'profile' => $profile
        ], 'admin');
    }

    public function updateUser(string $id): void
    {
        Csrf::verifyOrAbort();
        $userId = (int)$id;

        $fullName = trim($_POST['full_name'] ?? '');
        $rawMobile = trim($_POST['mobile'] ?? '');
        $status   = trim($_POST['status'] ?? 'active');

        $mobile = Helper::normalizeMobile($rawMobile);
        if (!$mobile || empty($fullName)) {
            Session::setFlash('error', 'اطلاعات نام یا موبایل نامعتبر است.');
            Helper::redirect("admin/users/edit/{$userId}");
        }

        User::update($userId, [
            'full_name' => $fullName,
            'mobile'    => $mobile,
            'status'    => $status
        ]);

        // Update Profile
        $profile = Profile::findByUserId($userId);
        $profileData = [
            'display_name' => trim($_POST['display_name'] ?? $fullName),
            'job_title'    => trim($_POST['job_title'] ?? ''),
            'company'      => trim($_POST['company'] ?? ''),
            'bio'          => trim($_POST['bio'] ?? ''),
            'email'        => trim($_POST['email'] ?? ''),
            'phone_work'   => trim($_POST['phone_work'] ?? ''),
            'website'      => trim($_POST['website'] ?? ''),
            'address'      => trim($_POST['address'] ?? ''),
            'is_active'    => isset($_POST['is_active']) ? 1 : 0
        ];

        if ($profile) {
            Profile::updateByUserId($userId, $profileData);
        } else {
            $profileData['user_id'] = $userId;
            Profile::create($profileData);
        }

        Session::setFlash('success', 'مشخصات کاربر و پروفایل با موفقیت بروزرسانی شد.');
        Helper::redirect("admin/users/edit/{$userId}");
    }

    public function transactions(): void
    {
        $transactions = Transaction::getAllWithDetails(100, 0);

        View::render('admin.transactions', [
            'title'        => 'مدیریت مالی و تراکنش‌ها - CIPCard',
            'transactions' => $transactions
        ], 'admin');
    }

    public function settings(): void
    {
        $settingsGrouped = Setting::getAllGrouped();

        View::render('admin.settings', [
            'title'    => 'تنظیمات سیستم - CIPCard',
            'settings' => $settingsGrouped
        ], 'admin');
    }

    public function updateSettings(): void
    {
        Csrf::verifyOrAbort();

        $allowedKeys = [
            'site_title',
            'site_description',
            'company_name',
            'support_phone',
            'support_email',
            'support_address',
            'branding_note',
            'social_instagram',
            'social_telegram',
            'social_whatsapp',
            'price_default_cip',
            'price_custom_design',
            'zarinpal_merchant_id',
            'zarinpal_sandbox',
            'sms_url_pattern',
            'sms_otp_template'
        ];

        $updates = [];
        foreach ($allowedKeys as $key) {
            if (isset($_POST[$key])) {
                $updates[$key] = trim($_POST[$key]);
            }
        }

        Setting::updateMultiple($updates);
        Session::setFlash('success', 'تنظیمات سیستم با موفقیت بروزرسانی شد.');
        Helper::redirect('admin/settings');
    }
}
