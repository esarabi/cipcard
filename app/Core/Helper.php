<?php
declare(strict_types=1);

namespace App\Core;

use App\Config\Config;

/**
 * Global System Helper
 */
class Helper
{
    /**
     * Convert Persian/Arabic digits to English digits
     */
    public static function toEnglishDigits(string $string): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic  = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $string = str_replace($persian, $english, $string);
        return str_replace($arabic, $english, $string);
    }

    /**
     * Standardize Iranian Mobile Phone Numbers to 09xxxxxxxxx
     */
    public static function normalizeMobile(string $mobile): ?string
    {
        $clean = self::toEnglishDigits(trim($mobile));
        $clean = preg_replace('/[^0-9]/', '', $clean);

        if (str_starts_with($clean, '0098')) {
            $clean = '0' . substr($clean, 4);
        } elseif (str_starts_with($clean, '98')) {
            $clean = '0' . substr($clean, 2);
        } elseif (strlen($clean) === 10 && str_starts_with($clean, '9')) {
            $clean = '0' . $clean;
        }

        if (preg_match('/^09[0-9]{9}$/', $clean)) {
            return $clean;
        }

        return null;
    }

    /**
     * Format number to Persian Toman currency
     */
    public static function formatPrice(int|float|string $amount): string
    {
        $englishFormatted = number_format((float)$amount);
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return str_replace($englishDigits, $persianDigits, $englishFormatted) . ' تومان';
    }

    /**
     * Escape HTML output
     */
    public static function e(?string $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate relative or absolute application URL
     */
    public static function url(string $path = ''): string
    {
        $baseUrl = rtrim(Config::APP_URL, '/');
        $path = ltrim($path, '/');
        return $path === '' ? $baseUrl : $baseUrl . '/' . $path;
    }

    /**
     * Generate asset URL
     */
    public static function asset(string $path): string
    {
        return self::url('assets/' . ltrim($path, '/'));
    }

    /**
     * Send JSON Response and exit
     */
    public static function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Redirect to specified URL
     */
    public static function redirect(string $path): void
    {
        header('Location: ' . self::url($path));
        exit;
    }
}
