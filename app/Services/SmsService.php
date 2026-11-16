<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Exception;

/**
 * URL-Based HTTP GET/POST SMS Service
 */
class SmsService
{
    /**
     * Send OTP Verification Code
     */
    public static function sendOtp(string $mobile, string $code): bool
    {
        $pattern = Setting::get('sms_url_pattern', '');
        $template = Setting::get('sms_otp_template', "کد تایید ورود شما به CIPCard:\n{code}\nاعتبار: ۲ دقیقه");

        $message = str_replace('{code}', $code, $template);
        return self::dispatch($pattern, $mobile, $message, $code);
    }

    /**
     * Send Arbitrary SMS Notification
     */
    public static function send(string $mobile, string $text): bool
    {
        $pattern = Setting::get('sms_url_pattern', '');
        return self::dispatch($pattern, $mobile, $text);
    }

    /**
     * Dispatch HTTP request using cURL
     */
    private static function dispatch(string $urlPattern, string $mobile, string $text, string $code = ''): bool
    {
        if (empty($urlPattern)) {
            error_log("SmsService Error: sms_url_pattern is not configured in settings.");
            return false;
        }

        // Replace placeholders
        $url = str_replace(
            ['{mobile}', '{text}', '{code}'],
            [rawurlencode($mobile), rawurlencode($text), rawurlencode($code)],
            $urlPattern
        );

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 12,
            CURLOPT_CONNECTTIMEOUT => 6,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_USERAGENT => 'CIPCard-SMS-Engine/1.0'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("SmsService cURL Error [{$mobile}]: {$error}");
            return false;
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        }

        error_log("SmsService HTTP Failure [{$mobile}] (HTTP {$httpCode}): {$response}");
        return false;
    }
}
