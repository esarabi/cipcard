<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Helper;
use PDO;

class OtpCode
{
    public static function generate(string $mobile, ?string $ip = null): string
    {
        $db = Database::getConnection();

        // Invalidate older unused codes for this number
        $stmt = $db->prepare("UPDATE otp_codes SET is_used = 1 WHERE mobile = :mobile AND is_used = 0");
        $stmt->execute([':mobile' => $mobile]);

        // Generate 5-digit code
        $code = (string)random_int(10000, 99999);

        // Store new code with 2-minute validity
        $stmt = $db->prepare("
            INSERT INTO otp_codes (mobile, code, expires_at, is_used, ip_address)
            VALUES (:mobile, :code, DATE_ADD(NOW(), INTERVAL 2 MINUTE), 0, :ip)
        ");
        $stmt->execute([
            ':mobile' => $mobile,
            ':code'   => $code,
            ':ip'     => $ip
        ]);

        return $code;
    }

    public static function verify(string $mobile, string $code): bool
    {
        $db = Database::getConnection();
        $code = Helper::toEnglishDigits(trim($code));

        $stmt = $db->prepare("
            SELECT id FROM otp_codes
            WHERE mobile = :mobile
              AND code = :code
              AND is_used = 0
              AND expires_at >= NOW()
            ORDER BY id DESC
            LIMIT 1
        ");
        $stmt->execute([
            ':mobile' => $mobile,
            ':code'   => $code
        ]);

        $otp = $stmt->fetch();
        if ($otp) {
            // Mark as used
            $update = $db->prepare("UPDATE otp_codes SET is_used = 1 WHERE id = :id");
            $update->execute([':id' => $otp['id']]);
            return true;
        }

        return false;
    }

    public static function cleanExpired(): void
    {
        $db = Database::getConnection();
        $db->query("DELETE FROM otp_codes WHERE expires_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
    }
}
