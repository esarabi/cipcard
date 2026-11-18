<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helper;
use App\Core\Session;
use App\Core\View;
use App\Models\Card;
use App\Models\Profile;
use App\Models\User;
use App\Services\QrCodeService;

class CardController
{
    /**
     * Handle public scanning of physical Smart Cards (e.g. /c/{code} or /card/{code})
     */
    public function scan(string $code): void
    {
        $cleanCode = strtoupper(trim($code));
        $card = Card::findByCode($cleanCode);

        if (!$card) {
            http_response_code(404);
            View::render('card.not_found', [
                'title' => 'کارت هوشمند یافت نشد - CIPCard',
                'code'  => $cleanCode
            ], 'main');
            return;
        }

        // Record scan statistics
        Card::recordScan((int)$card['id']);

        // 1. If card is assigned to a profile/user -> Redirect to profile
        if ($card['status'] === 'assigned' && !empty($card['user_id'])) {
            $profile = null;
            if (!empty($card['profile_id'])) {
                $profile = Profile::findById((int)$card['profile_id']);
            }
            if (!$profile) {
                $profile = Profile::findByUserId((int)$card['user_id']);
            }

            if ($profile) {
                $target = !empty($profile['slug']) ? '@' . $profile['slug'] : '@' . $card['user_mobile'];
                Helper::redirect($target);
                return;
            }

            // Fallback to user mobile
            if (!empty($card['user_mobile'])) {
                Helper::redirect('@' . $card['user_mobile']);
                return;
            }
        }

        // 2. If card is blocked
        if ($card['status'] === 'blocked') {
            http_response_code(403);
            View::render('card.blocked', [
                'title' => 'کارت هوشمند غیرفعال است - CIPCard',
                'card'  => $card
            ], 'main');
            return;
        }

        // 3. Card is UNASSIGNED (خام / در انتظار اتصال به کاربر)
        $qrCodeDataUri = QrCodeService::getDataUri(Helper::url('c/' . $card['card_code']), 320);

        View::render('card.unassigned', [
            'title'         => 'کارت هوشمند آماده اتصال - ' . $card['card_code'],
            'card'          => $card,
            'qrCodeDataUri' => $qrCodeDataUri,
            'isAdmin'       => Session::get('user_role') === 'admin',
            'isLoggedIn'    => Session::has('user_id')
        ], 'main');
    }

    /**
     * User self-claim / activation request from card scan (if logged in)
     */
    public function claim(string $code): void
    {
        $userId = (int)Session::get('user_id', 0);
        if (!$userId) {
            Session::setFlash('error', 'لطفاً ابتدا وارد حساب کاربری خود شوید.');
            Helper::redirect('auth/login');
            return;
        }

        $card = Card::findByCode($code);
        if (!$card || $card['status'] !== 'unassigned') {
            Session::setFlash('error', 'این کارت نامعتبر است یا قبلاً به کاربر دیگری متصل شده است.');
            Helper::redirect('dashboard');
            return;
        }

        // Assign card to user
        Card::assignToUser((int)$card['id'], $userId);

        Session::setFlash('success', "کارت هوشمند با کد {$card['card_code']} با موفقیت به پروفایل شما متصل شد!");
        Helper::redirect('dashboard');
    }
}
