<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use RuntimeException;

/**
 * Zarinpal REST Payment Gateway Service (API v4)
 */
class ZarinpalService
{
    private string $merchantId;
    private bool $isSandbox;

    public function __construct()
    {
        $this->merchantId = Setting::get('zarinpal_merchant_id', '00000000-0000-0000-0000-000000000000');
        $this->isSandbox = (bool)(int)Setting::get('zarinpal_sandbox', '1');
    }

    private function getBaseUrl(): string
    {
        return $this->isSandbox
            ? 'https://sandbox.zarinpal.com/pg/v4/payment/'
            : 'https://payment.zarinpal.com/pg/v4/payment/';
    }

    public function getStartPayUrl(string $authority): string
    {
        return $this->isSandbox
            ? "https://sandbox.zarinpal.com/pg/StartPay/{$authority}"
            : "https://payment.zarinpal.com/pg/StartPay/{$authority}";
    }

    /**
     * Request payment authority
     *
     * @param int $amount Amount in Toman
     * @param string $description Payment description
     * @param string $callbackUrl Callback URL after payment
     * @param string|null $mobile Customer mobile
     * @param string|null $email Customer email
     * @return array [success => bool, authority => ?string, message => ?string]
     */
    public function requestPayment(int $amount, string $description, string $callbackUrl, ?string $mobile = null, ?string $email = null): array
    {
        $url = $this->getBaseUrl() . 'request.json';

        $metadata = [];
        if (!empty($mobile)) {
            $metadata['mobile'] = $mobile;
        }
        if (!empty($email)) {
            $metadata['email'] = $email;
        }

        $payload = [
            'merchant_id'  => $this->merchantId,
            'amount'       => $amount * 10, // Zarinpal API v4 default is in Rials unless currency set to IRT. Passing Rials is most stable.
            'currency'     => 'IRR',
            'description'  => $description,
            'callback_url' => $callbackUrl,
            'metadata'     => $metadata
        ];

        $response = $this->postJson($url, $payload);

        if (isset($response['data']['code']) && $response['data']['code'] == 100) {
            return [
                'success'   => true,
                'authority' => $response['data']['authority'],
                'fee'       => $response['data']['fee'] ?? 0,
                'message'   => 'شناسه پرداخت با موفقیت ایجاد شد.'
            ];
        }

        $errorCode = $response['errors']['code'] ?? ($response['data']['code'] ?? 'Unknown');
        $errorMessage = $response['errors']['message'] ?? 'خطا در ارتباط با درگاه پرداخت زرین‌پال.';

        return [
            'success'   => false,
            'authority' => null,
            'message'   => "خطای درگاه زرین‌پال ({$errorCode}): {$errorMessage}"
        ];
    }

    /**
     * Verify completed payment
     *
     * @param string $authority Zarinpal authority
     * @param int $amount Amount in Toman
     * @return array [success => bool, ref_id => ?string, card_pan => ?string, fee => int, message => string]
     */
    public function verifyPayment(string $authority, int $amount): array
    {
        $url = $this->getBaseUrl() . 'verify.json';

        $payload = [
            'merchant_id' => $this->merchantId,
            'amount'      => $amount * 10, // in Rials
            'authority'   => $authority
        ];

        $response = $this->postJson($url, $payload);

        if (isset($response['data']['code']) && in_array((int)$response['data']['code'], [100, 101], true)) {
            return [
                'success'  => true,
                'ref_id'   => (string)$response['data']['ref_id'],
                'card_pan' => $response['data']['card_pan'] ?? null,
                'fee'      => (int)round(($response['data']['fee'] ?? 0) / 10), // Convert fee back to Toman
                'message'  => 'پرداخت با موفقیت انجام و تایید شد.'
            ];
        }

        $errorMessage = $response['errors']['message'] ?? 'تراکنش ناموفق بود یا توسط کاربر لغو شده است.';
        return [
            'success'  => false,
            'ref_id'   => null,
            'card_pan' => null,
            'fee'      => 0,
            'message'  => $errorMessage
        ];
    }

    private function postJson(string $url, array $data): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("Zarinpal cURL Error: {$error}");
            return ['errors' => ['message' => 'خطای اتصال شبکه به درگاه پرداخت: ' . $error]];
        }

        $decoded = json_decode((string)$result, true);
        return is_array($decoded) ? $decoded : ['errors' => ['message' => 'پاسخ نامعتبر از سرور درگاه: ' . $result]];
    }
}
