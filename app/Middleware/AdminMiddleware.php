<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Helper;
use App\Core\Session;

class AdminMiddleware
{
    public function handle(): void
    {
        Session::start();
        $role = Session::get('user_role');
        if (!Session::has('user_id') || $role !== 'admin') {
            Session::setFlash('error', 'دسترسی غیرمجاز. فقط مدیران سیستم مجاز به ورود به این بخش هستند.');
            Helper::redirect('admin/login');
        }
    }
}
