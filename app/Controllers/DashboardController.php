<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\Config;
use App\Core\Csrf;
use App\Core\Helper;
use App\Core\Session;
use App\Core\View;
use App\Models\Order;
use App\Models\Profile;
use App\Models\User;
use App\Services\QrCodeService;

class DashboardController
{
    private int $userId;

    public function __construct()
    {
        Session::start();
        $this->userId = (int)Session::get('user_id');
    }

    public function index(): void
    {
        $user = User::findById($this->userId);
        $profile = Profile::findByUserId($this->userId);
        $orders = Order::findByUserId($this->userId);
        $latestOrder = $orders[0] ?? null;

        $profileUrl = $profile ? Helper::url('@' . ($profile['slug'] ?: $user['mobile'])) : '';
        $qrCodeDataUri = $profile ? QrCodeService::getDataUri($profileUrl, 240) : '';

        View::render('user.dashboard', [
            'title'         => 'داشبورد کاربری - CIPCard',
            'user'          => $user,
            'profile'       => $profile,
            'orders'        => $orders,
            'latestOrder'   => $latestOrder,
            'profileUrl'    => $profileUrl,
            'qrCodeDataUri' => $qrCodeDataUri
        ], 'user');
    }

    public function editProfile(): void
    {
        $user = User::findById($this->userId);
        $profile = Profile::findByUserId($this->userId);

        View::render('user.edit_profile', [
            'title'   => 'ویرایش مشخصات پروفایل هوشمند - CIPCard',
            'user'    => $user,
            'profile' => $profile
        ], 'user');
    }

    public function updateProfile(): void
    {
        Csrf::verifyOrAbort();

        $displayName = trim($_POST['display_name'] ?? '');
        $jobTitle    = trim($_POST['job_title'] ?? '');
        $company     = trim($_POST['company'] ?? '');
        $bio         = trim($_POST['bio'] ?? '');
        $phoneMobile = trim($_POST['phone_mobile'] ?? '');
        $phoneWork   = trim($_POST['phone_work'] ?? '');
        $email       = trim($_POST['email'] ?? '');
        $website     = trim($_POST['website'] ?? '');
        $address     = trim($_POST['address'] ?? '');
        $templateId  = trim($_POST['template_id'] ?? 'minimal');
        $themeColor  = trim($_POST['theme_color'] ?? 'gold_black');

        $socialLinks = [
            'instagram' => trim($_POST['instagram'] ?? ''),
            'whatsapp'  => trim($_POST['whatsapp'] ?? ''),
            'telegram'  => trim($_POST['telegram'] ?? ''),
            'linkedin'  => trim($_POST['linkedin'] ?? ''),
            'github'    => trim($_POST['github'] ?? ''),
            'twitter'   => trim($_POST['twitter'] ?? '')
        ];

        if (empty($displayName)) {
            Session::setFlash('error', 'وارد کردن نام و نام خانوادگی الزامی است.');
            Helper::redirect('dashboard/profile');
        }

        $profileData = [
            'display_name' => $displayName,
            'job_title'    => $jobTitle,
            'company'      => $company,
            'bio'          => $bio,
            'phone_mobile' => $phoneMobile,
            'phone_work'   => $phoneWork,
            'email'        => $email,
            'website'      => $website,
            'address'      => $address,
            'template_id'  => $templateId,
            'theme_color'  => $themeColor,
            'social_links' => $socialLinks
        ];

        // Handle Avatar Upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['avatar'];
            if ($file['size'] <= Config::MAX_FILE_SIZE) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    if (!is_dir(Config::UPLOAD_AVATARS)) {
                        mkdir(Config::UPLOAD_AVATARS, 0755, true);
                    }
                    $newFileName = 'avatar_' . $this->userId . '_' . time() . '.' . $ext;
                    $dest = Config::UPLOAD_AVATARS . $newFileName;
                    if (move_uploaded_file($file['tmp_name'], $dest)) {
                        $profileData['avatar_url'] = 'uploads/avatars/' . $newFileName;
                    }
                }
            }
        }

        Profile::updateByUserId($this->userId, $profileData);
        Session::setFlash('success', 'تغییرات پروفایل با موفقیت ذخیره و فوراً اعمال شد.');
        Helper::redirect('dashboard/profile');
    }

    public function switchTemplate(): void
    {
        Csrf::verifyOrAbort();

        $templateId = trim($_POST['template_id'] ?? 'minimal');
        $themeColor = trim($_POST['theme_color'] ?? 'gold_black');

        Profile::updateByUserId($this->userId, [
            'template_id' => $templateId,
            'theme_color' => $themeColor
        ]);

        Session::setFlash('success', 'قالب و پالت رنگی با موفقیت تغییر یافت.');
        Helper::redirect('dashboard');
    }

    public function orderTracking(): void
    {
        $user = User::findById($this->userId);
        $orders = Order::findByUserId($this->userId);

        View::render('user.order_tracking', [
            'title'  => 'پیگیری وضعیت سفارشات - CIPCard',
            'user'   => $user,
            'orders' => $orders
        ], 'user');
    }
}
