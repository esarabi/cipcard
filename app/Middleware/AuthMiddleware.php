<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Helper;
use App\Core\Session;

class AuthMiddleware
{
    public function handle(): void
    {
        Session::start();
        if (!Session::has('user_id')) {
            Session::setFlash('error', 'برای دسترسی به این بخش، لطفاً ابتدا وارد حساب کاربری خود شوید.');
            Helper::redirect('auth/login');
        }
    }
}
