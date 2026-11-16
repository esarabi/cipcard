<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Cross-Site Request Forgery (CSRF) Protection
 */
class Csrf
{
    private const TOKEN_KEY = '_csrf_token';

    public static function getToken(): string
    {
        Session::start();
        $token = Session::get(self::TOKEN_KEY);
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            Session::set(self::TOKEN_KEY, $token);
        }
        return $token;
    }

    public static function validate(?string $token): bool
    {
        Session::start();
        $sessionToken = Session::get(self::TOKEN_KEY);
        if (!$sessionToken || !$token) {
            return false;
        }
        return hash_equals($sessionToken, $token);
    }

    public static function field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::getToken(), ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function verifyOrAbort(): void
    {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        if (!self::validate($token)) {
            http_response_code(403);
            die('خطای امنیتی CSRF: توکن ارسالی نامعتبر یا منقضی شده است. لطفاً صفحه را تازه‌سازی کنید.');
        }
    }
}
