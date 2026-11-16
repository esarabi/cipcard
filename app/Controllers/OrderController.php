<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\Config;
use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\ZarinpalService;

class OrderController
{
    /**
     * Retry payment for an unpaid order
     */
    public function retry(string $orderNumber): void
    {
        Session::start();
        $userId = Session::get('user_id');

        $order = Order::findByOrderNumber($orderNumber);
        if (!$order || (int)$order['user_id'] !== (int)$userId) {
            Session::setFlash('error', 'سفارش مورد نظر یافت نشد.');
            Helper::redirect('dashboard');
        }

        if ($order['status'] !== 'unpaid') {
            Session::setFlash('info', 'این سفارش قبلاً پرداخت شده است.');
            Helper::redirect('dashboard');
        }

        $zarinpal = new ZarinpalService();
        $callbackUrl = Helper::url('payment/callback');
        $description = "پرداخت مجدد سفارش کارت هوشمند - شماره: {$order['order_number']}";

        $payResult = $zarinpal->requestPayment(
            (int)$order['amount'],
            $description,
            $callbackUrl,
            $order['mobile'],
            null
        );

        if ($payResult['success'] && !empty($payResult['authority'])) {
            Transaction::create([
                'order_id'  => (int)$order['id'],
                'user_id'   => (int)$userId,
                'authority' => $payResult['authority'],
                'amount'    => (int)$order['amount'],
                'gateway'   => 'zarinpal',
                'status'    => 'pending'
            ]);

            $startPayUrl = $zarinpal->getStartPayUrl($payResult['authority']);
            header("Location: {$startPayUrl}");
            exit;
        }

        Session::setFlash('error', 'خطا در اتصال به درگاه پرداخت: ' . ($payResult['message'] ?? ''));
        Helper::redirect('dashboard');
    }

    /**
     * Upload custom design / logo file for Custom Design Orders
     */
    public function uploadDesign(): void
    {
        Csrf::verifyOrAbort();
        Session::start();
        $userId = Session::get('user_id');

        $orderId = (int)($_POST['order_id'] ?? 0);
        $notes = trim($_POST['custom_design_notes'] ?? '');

        $order = Order::findById($orderId);
        if (!$order || (int)$order['user_id'] !== (int)$userId) {
            Session::setFlash('error', 'سفارش یافت نشد.');
            Helper::redirect('dashboard');
        }

        if (!isset($_FILES['design_file']) || $_FILES['design_file']['error'] !== UPLOAD_ERR_OK) {
            Session::setFlash('error', 'لطفاً یک فایل معتبر انتخاب کنید.');
            Helper::redirect('dashboard');
        }

        $file = $_FILES['design_file'];
        if ($file['size'] > Config::MAX_FILE_SIZE) {
            Session::setFlash('error', 'حجم فایل نباید بیش از ۱۵ مگابایت باشد.');
            Helper::redirect('dashboard');
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf', 'zip', 'rar', 'ai', 'psd'];
        if (!in_array($ext, $allowedExtensions, true)) {
            Session::setFlash('error', 'فرمت فایل مجاز نیست (فقط تصاویر، PDF، ZIP، PSD یا AI مجاز است).');
            Helper::redirect('dashboard');
        }

        if (!is_dir(Config::UPLOAD_DESIGNS)) {
            mkdir(Config::UPLOAD_DESIGNS, 0755, true);
        }

        $filename = 'design_' . $order['order_number'] . '_' . time() . '.' . $ext;
        $destPath = Config::UPLOAD_DESIGNS . $filename;

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            $webPath = 'uploads/designs/' . $filename;
            Order::updateDesign($orderId, $webPath, $notes);
            Order::updateStatus($orderId, 'printing'); // Advance to printing after receiving design
            Session::setFlash('success', 'فایل طرح اختصاصی با موفقیت بارگذاری شد و سفارش وارد مرحله چاپ شد.');
        } else {
            Session::setFlash('error', 'خطا در بارگذاری فایل در سرور.');
        }

        Helper::redirect('dashboard');
    }
}
