<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helper;
use App\Core\Session;
use App\Models\Order;
use App\Models\Profile;
use App\Models\Transaction;
use App\Services\ZarinpalService;

class PaymentController
{
    /**
     * Step 4 of User Flow: Process Zarinpal Payment Callback
     */
    public function callback(): void
    {
        $authority = trim($_GET['Authority'] ?? '');
        $status = trim($_GET['Status'] ?? '');

        if (empty($authority)) {
            Session::setFlash('error', 'شناسه تراکنش نامعتبر است.');
            Helper::redirect('dashboard');
        }

        $transaction = Transaction::findByAuthority($authority);
        if (!$transaction) {
            Session::setFlash('error', 'تراکنشی با این شناسه در سیستم یافت نشد.');
            Helper::redirect('dashboard');
        }

        // Auto-login user if session expired during payment
        Session::start();
        if (!Session::has('user_id')) {
            Session::set('user_id', (int)$transaction['user_id']);
            Session::set('user_name', $transaction['full_name']);
            Session::set('user_mobile', $transaction['mobile']);
            Session::set('user_role', 'user');
        }

        $order = Order::findById((int)$transaction['order_id']);

        if ($status === 'OK') {
            $zarinpal = new ZarinpalService();
            $verifyResult = $zarinpal->verifyPayment($authority, (int)$transaction['amount']);

            if ($verifyResult['success']) {
                $refId = $verifyResult['ref_id'];
                $cardPan = $verifyResult['card_pan'];
                $fee = $verifyResult['fee'];

                // 1. Mark transaction successful
                Transaction::updateStatus((int)$transaction['id'], 'success', $refId, $cardPan, $fee);

                // 2. Advance order status
                $nextOrderStatus = ($order['card_type'] === 'custom_design') ? 'pending_design' : 'printing';
                Order::updateStatus((int)$order['id'], $nextOrderStatus);

                // 3. Activate user profile
                Profile::updateByUserId((int)$transaction['user_id'], ['is_active' => 1]);

                Session::setFlash('success', "پرداخت شما با موفقیت انجام شد! شماره پیگیری: {$refId}");
                Helper::redirect("dashboard?payment=success&ref_id={$refId}");
            } else {
                // Payment verification failed
                Transaction::updateStatus((int)$transaction['id'], 'failed', null, null, 0, $verifyResult['message']);
                Session::setFlash('error', 'تایید پرداخت ناموفق بود: ' . $verifyResult['message']);
                Helper::redirect('dashboard?payment=failed');
            }
        } else {
            // Cancelled by user
            Transaction::updateStatus((int)$transaction['id'], 'failed', null, null, 0, 'تراکنش توسط کاربر در درگاه پرداخت لغو گردید.');
            Session::setFlash('warning', 'عملیات پرداخت لغو شد. سفارش شما ذخیره شده و می‌توانید در هر زمان از پنل کاربری نسبت به پرداخت آن اقدام کنید.');
            Helper::redirect('dashboard?payment=cancelled');
        }
    }
}
