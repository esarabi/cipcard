<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Config;

/**
 * Standard vCard (.vcf) Generator for One-Click Contact Saving
 */
class VCardService
{
    public static function generate(array $profile): string
    {
        $fullName   = trim($profile['display_name'] ?? '');
        $company    = trim($profile['company'] ?? '');
        $jobTitle   = trim($profile['job_title'] ?? '');
        $cellPhone  = trim($profile['phone_mobile'] ?? ($profile['mobile'] ?? ''));
        $workPhone  = trim($profile['phone_work'] ?? '');
        $email      = trim($profile['email'] ?? '');
        $website    = trim($profile['website'] ?? '');
        $address    = trim($profile['address'] ?? '');
        $bio        = trim($profile['bio'] ?? '');

        $lines = [];
        $lines[] = 'BEGIN:VCARD';
        $lines[] = 'VERSION:3.0';
        $lines[] = 'PRODID:-//CIPCard Platform//FA';
        $lines[] = 'FN;CHARSET=UTF-8:' . self::escape($fullName);
        $lines[] = 'N;CHARSET=UTF-8:' . self::escape($fullName) . ';;;;';

        if (!empty($company)) {
            $lines[] = 'ORG;CHARSET=UTF-8:' . self::escape($company);
        }
        if (!empty($jobTitle)) {
            $lines[] = 'TITLE;CHARSET=UTF-8:' . self::escape($jobTitle);
        }
        if (!empty($cellPhone)) {
            $lines[] = 'TEL;TYPE=CELL,VOICE:' . $cellPhone;
        }
        if (!empty($workPhone)) {
            $lines[] = 'TEL;TYPE=WORK,VOICE:' . $workPhone;
        }
        if (!empty($email)) {
            $lines[] = 'EMAIL;TYPE=PREF,INTERNET:' . $email;
        }
        if (!empty($website)) {
            $lines[] = 'URL:' . $website;
        }
        if (!empty($address)) {
            $lines[] = 'ADR;TYPE=WORK;CHARSET=UTF-8:;;' . self::escape($address) . ';;;;';
        }
        if (!empty($bio)) {
            $lines[] = 'NOTE;CHARSET=UTF-8:' . self::escape($bio);
        }

        // Embed Profile Avatar if available
        if (!empty($profile['avatar_url'])) {
            $avatarPath = __DIR__ . '/../../public/' . ltrim($profile['avatar_url'], '/');
            if (file_exists($avatarPath) && is_readable($avatarPath)) {
                $ext = strtolower(pathinfo($avatarPath, PATHINFO_EXTENSION));
                $type = in_array($ext, ['png', 'jpg', 'jpeg'], true) ? strtoupper($ext) : 'JPEG';
                $photoData = base64_encode((string)file_get_contents($avatarPath));
                $lines[] = 'PHOTO;ENCODING=b;TYPE=' . $type . ':' . $photoData;
            }
        }

        $lines[] = 'END:VCARD';
        return implode("\r\n", $lines) . "\r\n";
    }

    public static function download(array $profile): void
    {
        $vcfContent = self::generate($profile);
        $filename = preg_replace('/[^a-zA-Z0-9_\-\x{0600}-\x{06FF}]/u', '_', $profile['display_name'] ?? 'contact') . '.vcf';

        header('Content-Type: text/vcard; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($vcfContent));
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo $vcfContent;
        exit;
    }

    private static function escape(string $text): string
    {
        return str_replace(["\r\n", "\n", "\r", ';', ','], [' ', ' ', ' ', '\;', '\,'], $text);
    }
}
