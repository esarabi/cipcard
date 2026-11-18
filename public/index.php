<?php
declare(strict_types=1);

/**
 * CIPCard Platform - Front Controller
 * Brand: CIPCard (cipcard.ir)
 * PHP 8.2+ Clean MVC & Routing Architecture
 */

// Production error logging configuration
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// 1. PSR-4 Autoloader with Case-Insensitive Fallback for Linux Filesystems
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $path = str_replace('\\', '/', $relativeClass) . '.php';

    // A. Standard PSR-4 Exact Path
    if (file_exists($baseDir . $path)) {
        require_once $baseDir . $path;
        return;
    }

    // B. Lowercase Filename Fallback (e.g. Config/config.php)
    $parts = explode('/', $path);
    $filename = array_pop($parts);
    $dirPart = count($parts) ? implode('/', $parts) . '/' : '';
    
    $lowerFile = $baseDir . $dirPart . strtolower($filename);
    if (file_exists($lowerFile)) {
        require_once $lowerFile;
        return;
    }

    // C. Lowercase Directory Fallback (e.g. config/Config.php)
    $lowerAll = $baseDir . strtolower($path);
    if (file_exists($lowerAll)) {
        require_once $lowerAll;
        return;
    }
});

// Also include composer autoload if available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

use App\Config\Config;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\CardController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\OrderController;
use App\Controllers\PaymentController;
use App\Controllers\ProfileController;
use App\Controllers\SitemapController;
use App\Core\Router;
use App\Core\Session;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;

// Initialize Configuration and Session
Config::init();
Session::start();

// Initialize Router
$router = new Router();

// -------------------------------------------------------------
// SEO: Dynamic XML Sitemap & robots.txt for Google Search Console
// -------------------------------------------------------------
$router->get('/sitemap.xml', [SitemapController::class, 'sitemap']);
$router->get('/robots.txt', [SitemapController::class, 'robots']);

// -------------------------------------------------------------
// Public Landing Page & Fast Order Flow
// -------------------------------------------------------------
$router->get('/', [HomeController::class, 'index']);
$router->post('/api/order/fast', [HomeController::class, 'fastOrder']);

// -------------------------------------------------------------
// Authentication (Password & Passwordless OTP & Admin Login)
// -------------------------------------------------------------
$router->get('/auth/login', [AuthController::class, 'showLogin']);
$router->post('/auth/password/login', [AuthController::class, 'loginWithPassword']);
$router->post('/auth/otp/send', [AuthController::class, 'sendOtp']);
$router->post('/auth/otp/verify', [AuthController::class, 'verifyOtp']);
$router->get('/auth/logout', [AuthController::class, 'logout']);
$router->post('/auth/logout', [AuthController::class, 'logout']);

$router->get('/admin/login', [AuthController::class, 'showAdminLogin']);
$router->post('/admin/login', [AuthController::class, 'adminLoginSubmit']);

// -------------------------------------------------------------
// Payment & Orders
// -------------------------------------------------------------
$router->get('/payment/callback', [PaymentController::class, 'callback']);
$router->get('/order/retry/{orderNumber}', [OrderController::class, 'retry']);
$router->post('/order/upload-design', [OrderController::class, 'uploadDesign'], [AuthMiddleware::class]);

// -------------------------------------------------------------
// User Dashboard (Customer Panel)
// -------------------------------------------------------------
$router->get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$router->get('/dashboard/profile', [DashboardController::class, 'editProfile'], [AuthMiddleware::class]);
$router->post('/dashboard/profile', [DashboardController::class, 'updateProfile'], [AuthMiddleware::class]);
$router->post('/dashboard/password/change', [DashboardController::class, 'changePassword'], [AuthMiddleware::class]);
$router->post('/dashboard/switch-template', [DashboardController::class, 'switchTemplate'], [AuthMiddleware::class]);
$router->get('/dashboard/tracking', [DashboardController::class, 'orderTracking'], [AuthMiddleware::class]);
$router->get('/dashboard/orders', [DashboardController::class, 'orderTracking'], [AuthMiddleware::class]);
$router->post('/dashboard/order/new', [DashboardController::class, 'newOrder'], [AuthMiddleware::class]);

// Customer Reviews Management in User Dashboard
$router->get('/dashboard/reviews', [DashboardController::class, 'reviews'], [AuthMiddleware::class]);
$router->post('/dashboard/reviews/status', [DashboardController::class, 'updateReviewStatus'], [AuthMiddleware::class]);
$router->post('/dashboard/reviews/reply', [DashboardController::class, 'replyReview'], [AuthMiddleware::class]);
$router->post('/dashboard/reviews/delete', [DashboardController::class, 'deleteReview'], [AuthMiddleware::class]);

// -------------------------------------------------------------
// Admin Panel (Protected by AdminMiddleware)
// -------------------------------------------------------------
$router->get('/admin', [AdminController::class, 'dashboard'], [AdminMiddleware::class]);
$router->get('/admin/orders', [AdminController::class, 'orders'], [AdminMiddleware::class]);
$router->post('/admin/orders/status', [AdminController::class, 'updateOrderStatus'], [AdminMiddleware::class]);
$router->get('/admin/users', [AdminController::class, 'users'], [AdminMiddleware::class]);
$router->get('/admin/users/edit/{id}', [AdminController::class, 'editUser'], [AdminMiddleware::class]);
$router->post('/admin/users/edit/{id}', [AdminController::class, 'updateUser'], [AdminMiddleware::class]);
$router->get('/admin/transactions', [AdminController::class, 'transactions'], [AdminMiddleware::class]);
$router->get('/admin/settings', [AdminController::class, 'settings'], [AdminMiddleware::class]);
$router->post('/admin/settings', [AdminController::class, 'updateSettings'], [AdminMiddleware::class]);
$router->post('/admin/settings/test-sms', [AdminController::class, 'testSms'], [AdminMiddleware::class]);

// Admin Card & Bulk QR Code Management
$router->get('/admin/cards', [AdminController::class, 'cards'], [AdminMiddleware::class]);
$router->post('/admin/cards/bulk-generate', [AdminController::class, 'bulkGenerateCards'], [AdminMiddleware::class]);
$router->post('/admin/cards/assign', [AdminController::class, 'assignCard'], [AdminMiddleware::class]);
$router->post('/admin/cards/unbind', [AdminController::class, 'unbindCard'], [AdminMiddleware::class]);
$router->post('/admin/cards/delete', [AdminController::class, 'deleteCard'], [AdminMiddleware::class]);
$router->get('/admin/cards/export/zip', [AdminController::class, 'exportCardsZip'], [AdminMiddleware::class]);
$router->get('/admin/cards/export/csv', [AdminController::class, 'exportCardsCsv'], [AdminMiddleware::class]);
$router->get('/admin/cards/print', [AdminController::class, 'printCards'], [AdminMiddleware::class]);

// -------------------------------------------------------------
// Public Physical Smart Card Scan & Redirection (/c/{code})
// -------------------------------------------------------------
$router->get('/c/{code}', [CardController::class, 'scan']);
$router->get('/card/{code}', [CardController::class, 'scan']);
$router->post('/c/{code}/claim', [CardController::class, 'claim'], [AuthMiddleware::class]);

// -------------------------------------------------------------
// Public NFC Profiles (cipcard.ir/@09xxxxxxxxx), vCard & QR
// -------------------------------------------------------------
$router->get('/@{mobile}', [ProfileController::class, 'show']);
$router->post('/@{mobile}/review', [ProfileController::class, 'submitReview']);
$router->post('/api/profile/{mobile}/review', [ProfileController::class, 'submitReview']);
$router->post('/api/profile/review', [ProfileController::class, 'submitReviewGeneric']);
$router->get('/vcard/@{mobile}', [ProfileController::class, 'vcard']);
$router->get('/qr/@{mobile}', [ProfileController::class, 'qr']);

// Dispatch Incoming Request
$router->dispatch();
