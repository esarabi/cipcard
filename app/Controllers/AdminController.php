<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;
use App\Core\View;
use App\Models\Card;
use App\Models\Order;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Services\QrCodeService;
use ZipArchive;

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
        $userCards = Card::getByUserId($userId);
        $unassignedCards = Card::getAll(100, 0, ['status' => 'unassigned']);

        View::render('admin.user_edit', [
            'title'           => 'ویرایش مشخصات کاربر - ' . $user['full_name'],
            'user'            => $user,
            'profile'         => $profile,
            'userCards'       => $userCards,
            'unassignedCards' => $unassignedCards
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

    public function testSms(): void
    {
        Csrf::verifyOrAbort();

        $rawMobile = trim($_POST['mobile'] ?? '');
        $mobile = Helper::normalizeMobile($rawMobile);

        if (!$mobile) {
            Session::setFlash('error', 'شماره موبایل برای تست نامعتبر است.');
            Helper::redirect('admin/settings');
        }

        $res = \App\Services\SmsService::sendWithDetails($mobile, 'پیامک تست اتصال وب‌سرویس از پلتفرم CIPCard');
        if ($res['success']) {
            Session::setFlash('success', 'ارسال پیامک تست موفقیت‌آمیز بود! پاسخ وب‌سرویس: ' . $res['response']);
        } else {
            Session::setFlash('error', $res['error'] . ' | پاسخ خام وب‌سرویس: ' . ($res['response'] ?: 'هیچ پاسخی دریافت نشد'));
        }

        Helper::redirect('admin/settings');
    }

    /**
     * Card & QR Code Management Dashboard
     */
    public function cards(): void
    {
        $status = trim($_GET['status'] ?? '');
        $batchName = trim($_GET['batch_name'] ?? '');
        $search = trim($_GET['q'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 50;
        $offset = ($page - 1) * $limit;

        $filters = [];
        if ($status !== '' && in_array($status, ['unassigned', 'assigned', 'blocked'], true)) {
            $filters['status'] = $status;
        }
        if ($batchName !== '') {
            $filters['batch_name'] = $batchName;
        }
        if ($search !== '') {
            $filters['search'] = $search;
        }

        $cards = Card::getAll($limit, $offset, $filters);
        $totalCards = Card::countAll($filters);
        $totalPages = (int)ceil($totalCards / $limit);
        $stats = Card::getStats();
        $batches = Card::getBatches();
        $users = User::getAll(500, 0); // For assignment dropdown

        View::render('admin.cards', [
            'title'       => 'مدیریت کارت‌ها و QR Code - CIPCard',
            'cards'       => $cards,
            'totalCards'  => $totalCards,
            'totalPages'  => $totalPages,
            'currentPage' => $page,
            'stats'       => $stats,
            'batches'     => $batches,
            'users'       => $users,
            'filters'     => [
                'status'     => $status,
                'batch_name' => $batchName,
                'search'     => $search
            ]
        ], 'admin');
    }

    /**
     * Bulk generate cards
     */
    public function bulkGenerateCards(): void
    {
        Csrf::verifyOrAbort();

        $count = (int)($_POST['count'] ?? 10);
        $batchName = trim($_POST['batch_name'] ?? '');
        $prefix = trim($_POST['prefix'] ?? 'CIP-');
        $notes = trim($_POST['notes'] ?? '');

        try {
            $result = Card::bulkGenerate($count, $batchName, $prefix, $notes);
            Session::setFlash('success', "تعداد {$result['count']} کارت هوشمند و بارکد QR با موفقیت در دسته «{$result['batch_name']}» تولید گردید.");
            Helper::redirect('admin/cards?batch_name=' . urlencode($result['batch_name']));
        } catch (\Exception $e) {
            Session::setFlash('error', 'خطا در تولید کارت‌ها: ' . $e->getMessage());
            Helper::redirect('admin/cards');
        }
    }

    /**
     * Assign card to user
     */
    public function assignCard(): void
    {
        Csrf::verifyOrAbort();

        $cardId = (int)($_POST['card_id'] ?? 0);
        $userId = (int)($_POST['user_id'] ?? 0);
        $cardCode = trim($_POST['card_code'] ?? '');
        $redirectBack = trim($_POST['redirect_back'] ?? 'admin/cards');

        if ($cardId <= 0 && !empty($cardCode)) {
            $card = Card::findByCode($cardCode);
            if ($card) {
                $cardId = (int)$card['id'];
            }
        }

        if ($cardId <= 0 || $userId <= 0) {
            Session::setFlash('error', 'لطفاً کارت و کاربر مورد نظر را به درستی انتخاب کنید.');
            Helper::redirect($redirectBack);
            return;
        }

        $ok = Card::assignToUser($cardId, $userId);
        if ($ok) {
            $user = User::findById($userId);
            $card = Card::findById($cardId);
            Session::setFlash('success', "کارت {$card['card_code']} با موفقیت به کاربر {$user['full_name']} ({$user['mobile']}) متصل شد.");
        } else {
            Session::setFlash('error', 'خطا در اتصال کارت به کاربر.');
        }

        Helper::redirect($redirectBack);
    }

    /**
     * Unbind card from user
     */
    public function unbindCard(): void
    {
        Csrf::verifyOrAbort();

        $cardId = (int)($_POST['card_id'] ?? 0);
        $redirectBack = trim($_POST['redirect_back'] ?? 'admin/cards');

        if ($cardId > 0) {
            Card::unbind($cardId);
            Session::setFlash('success', 'اتصال کارت از کاربر برداشته شد و به وضعیت خام درآمد.');
        }

        Helper::redirect($redirectBack);
    }

    /**
     * Delete unassigned card
     */
    public function deleteCard(): void
    {
        Csrf::verifyOrAbort();

        $cardId = (int)($_POST['card_id'] ?? 0);
        if ($cardId > 0) {
            Card::delete($cardId);
            Session::setFlash('success', 'کارت با موفقیت حذف شد.');
        }

        Helper::redirect('admin/cards');
    }

    /**
     * Export QR Codes as ZIP archive
     */
    public function exportCardsZip(): void
    {
        $batchName = trim($_GET['batch_name'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $filters = [];
        if ($batchName !== '') $filters['batch_name'] = $batchName;
        if ($status !== '') $filters['status'] = $status;

        $cards = Card::getAll(1000, 0, $filters);
        if (empty($cards)) {
            Session::setFlash('error', 'هیچ کارتی برای خروجی زیپ یافت نشد.');
            Helper::redirect('admin/cards');
            return;
        }

        if (!class_exists('ZipArchive')) {
            Session::setFlash('error', 'اکستنشن ZipArchive در سرور فعال نیست.');
            Helper::redirect('admin/cards');
            return;
        }

        $zip = new ZipArchive();
        $tempFile = tempnam(sys_get_temp_dir(), 'cip_zip_');
        if ($zip->open($tempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            Session::setFlash('error', 'امکان ایجاد فایل فشرده موقت وجود ندارد.');
            Helper::redirect('admin/cards');
            return;
        }

        // CSV Manifest inside ZIP
        $csvContent = "\xEF\xBB\xBF"; // UTF-8 BOM
        $csvContent .= "شناسه,کد کارت,آدرس اسکن,دسته چاپ,وضعیت,نام کاربر,شماره موبایل,تعداد اسکن\n";

        foreach ($cards as $card) {
            $scanUrl = Helper::url('c/' . $card['card_code']);
            $pngBytes = QrCodeService::getPngBytes($scanUrl, 600);
            if ($pngBytes) {
                $zip->addFromString("qrcodes/{$card['card_code']}.png", $pngBytes);
            }

            $userMobile = $card['user_mobile'] ?? '';
            $userName = $card['user_full_name'] ?? '';
            $statusFa = $card['status'] === 'assigned' ? 'متصل' : ($card['status'] === 'blocked' ? 'مسدود' : 'خام');
            $csvContent .= "{$card['id']},{$card['card_code']},{$scanUrl},\"{$card['batch_name']}\",{$statusFa},\"{$userName}\",{$userMobile},{$card['scan_count']}\n";
        }

        $zip->addFromString("manifest_cards.csv", $csvContent);
        $zip->addFromString("README.txt", "CIPCard.ir - Industrial QR Code Batch Export\nGenerated at: " . date('Y-m-d H:i:s') . "\nTotal Cards: " . count($cards));
        $zip->close();

        $safeName = $batchName !== '' ? preg_replace('/[^a-zA-Z0-9_\-]/', '_', $batchName) : 'batch';
        $filename = "cipcard_qrcodes_{$safeName}_" . date('Ymd_His') . ".zip";

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($tempFile));
        header('Pragma: no-cache');
        readfile($tempFile);
        @unlink($tempFile);
        exit;
    }

    /**
     * Export cards list as CSV
     */
    public function exportCardsCsv(): void
    {
        $batchName = trim($_GET['batch_name'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $filters = [];
        if ($batchName !== '') $filters['batch_name'] = $batchName;
        if ($status !== '') $filters['status'] = $status;

        $cards = Card::getAll(2000, 0, $filters);

        $safeName = $batchName !== '' ? preg_replace('/[^a-zA-Z0-9_\-]/', '_', $batchName) : 'cards';
        $filename = "cipcard_list_{$safeName}_" . date('Ymd_His') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        // UTF-8 BOM for Persian Excel support
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['شناسه', 'کد کارت', 'آدرس اسکن مستقیم', 'دسته چاپ', 'وضعیت', 'نام کاربر متصل', 'شماره موبایل کاربر', 'اسلاگ پروفایل', 'تعداد اسکن', 'تاریخ ایجاد']);

        foreach ($cards as $c) {
            $statusFa = $c['status'] === 'assigned' ? 'متصل' : ($c['status'] === 'blocked' ? 'مسدود' : 'خام');
            fputcsv($out, [
                $c['id'],
                $c['card_code'],
                Helper::url('c/' . $c['card_code']),
                $c['batch_name'] ?? '',
                $statusFa,
                $c['user_full_name'] ?? '',
                $c['user_mobile'] ?? '',
                $c['profile_slug'] ?? '',
                $c['scan_count'],
                $c['created_at']
            ]);
        }
        fclose($out);
        exit;
    }

    /**
     * Printable A4 Sheet Grid View for Card Manufacturing & Printing
     */
    public function printCards(): void
    {
        $batchName = trim($_GET['batch_name'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $filters = [];
        if ($batchName !== '') $filters['batch_name'] = $batchName;
        if ($status !== '') $filters['status'] = $status;

        $cards = Card::getAll(500, 0, $filters);

        View::render('admin.cards_print', [
            'title'     => 'برگه چاپ بارکدهای QR - ' . ($batchName ?: 'CIPCard'),
            'cards'     => $cards,
            'batchName' => $batchName
        ], null); // Direct view rendering without master layout
    }
}
