<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;

/**
 * URL-Based HTTP GET/POST SMS Service for Iranian Providers (iSMS, Kavenegar, FarazSMS, etc.)
 */
class SmsService
{
    /**
     * Send OTP Verification Code
     */
    public static function sendOtp(string $mobile, string $code): bool
    {
        $res = self::sendOtpDetails($mobile, $code);
        return $res['success'];
    }

    /**
     * Send OTP Verification Code with detailed response & error reporting
     *
     * @return array{success: bool, error: string, response: string}
     */
    public static function sendOtpDetails(string $mobile, string $code): array
    {
        $pattern = Setting::get('sms_url_pattern', '');
        $template = Setting::get('sms_otp_template', "کد تایید ورود شما به CIPCard:\n{code}\nاعتبار: ۲ دقیقه");

        $message = str_replace('{code}', $code, $template);
        return self::sendWithDetails($mobile, $message, $code);
    }

    /**
     * Send Arbitrary SMS Notification
     */
    public static function send(string $mobile, string $text): bool
    {
        $res = self::sendWithDetails($mobile, $text);
        return $res['success'];
    }

    /**
     * Dispatch HTTP request using cURL and return detailed diagnostic information
     *
     * @return array{success: bool, error: string, response: string}
     */
    public static function sendWithDetails(string $mobile, string $text, string $code = ''): array
    {
        $urlPattern = Setting::get('sms_url_pattern', '');
        if (empty($urlPattern)) {
            $err = 'الگوی آدرس پیامک (sms_url_pattern) در تنظیمات سیستم ثبت نشده است.';
            error_log("SmsService Error: {$err}");
            return ['success' => false, 'error' => $err, 'response' => ''];
        }

        // Replace placeholders: {mobile}, {text}, {code}
        $url = str_replace(
            ['{mobile}', '{text}', '{code}'],
            [rawurlencode($mobile), rawurlencode($text), rawurlencode($code)],
            $urlPattern
        );

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_USERAGENT => 'CIPCard-SMS-Engine/1.0'
        ]);

        $response = (string)curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            $err = "خطای ارتباط با سرور پیامک: {$curlError}";
            error_log("SmsService cURL Error [{$mobile}]: {$curlError}");
            return ['success' => false, 'error' => $err, 'response' => ''];
        }

        // Parse JSON response if returned by provider
        $json = json_decode($response, true);
        if (is_array($json)) {
            // Check known provider error codes (e.g., isms.ir, FarazSMS, Kavenegar)
            if (isset($json['code'])) {
                $codeNum = (int)$json['code'];
                if ($codeNum === 6 || stripos($json['message'] ?? '', 'not enough') !== false) {
                    $err = 'اعتبار حساب پنل پیامک (isms.ir) به اتمام رسیده است (The total account is not enough). لطفاً پنل پیامک را شارژ فرمایید.';
                    error_log("SmsService Failure [{$mobile}]: {$err} | Raw: {$response}");
                    return ['success' => false, 'error' => $err, 'response' => $response];
                }

                if (!in_array($codeNum, [0, 1, 200], true)) {
                    $msg = $json['message'] ?? "کد خطای {$codeNum}";
                    $err = "پاسخ خطای وب‌سرویس پیامک: {$msg}";
                    error_log("SmsService Provider Error [{$mobile}]: {$err} | Raw: {$response}");
                    return ['success' => false, 'error' => $err, 'response' => $response];
                }
            }

            if (isset($json['status']) && !in_array($json['status'], ['success', 'ok', 200, 1], true)) {
                $msg = $json['message'] ?? (string)$json['status'];
                $err = "وضعیت ناموفق پیامک: {$msg}";
                error_log("SmsService Provider Error [{$mobile}]: {$err} | Raw: {$response}");
                return ['success' => false, 'error' => $err, 'response' => $response];
            }
        }

        // Also check raw string response for known error keywords
        if (stripos($response, 'not enough') !== false || stripos($response, 'اعتبار') !== false && stripos($response, 'کافی') !== false) {
            $err = 'اعتبار حساب پنل پیامک به اتمام رسیده است. لطفاً پنل پیامک را شارژ فرمایید.';
            error_log("SmsService Failure [{$mobile}]: {$err} | Raw: {$response}");
            return ['success' => false, 'error' => $err, 'response' => $response];
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            error_log("SmsService Success [{$mobile}] -> HTTP {$httpCode}: {$response}");
            return ['success' => true, 'error' => '', 'response' => $response];
        }

        $err = "خطای سرور پیامک (HTTP {$httpCode})";
        error_log("SmsService HTTP Failure [{$mobile}] (HTTP {$httpCode}): {$response}");
        return ['success' => false, 'error' => $err, 'response' => $response];
    }
}
