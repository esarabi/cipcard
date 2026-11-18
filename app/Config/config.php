<?php
declare(strict_types=1);

namespace App\Config;

/**
 * Global Application Configuration
 * Brand: CIPCard (cipcard.ir)
 */
class Config
{
    public const APP_NAME = 'CIPCard';
    public const APP_URL = 'https://cipcard.ir';
    public const APP_VERSION = '1.0.0';
    public const TIMEZONE = 'Asia/Tehran';
    public const DEFAULT_LOCALE = 'fa_IR';

    public const UPLOAD_DIR = __DIR__ . '/../../public/uploads/';
    public const UPLOAD_AVATARS = self::UPLOAD_DIR . 'avatars/';
    public const UPLOAD_COVERS = self::UPLOAD_DIR . 'covers/';
    public const UPLOAD_GALLERY = self::UPLOAD_DIR . 'gallery/';
    public const UPLOAD_DESIGNS = self::UPLOAD_DIR . 'designs/';

    // Allowed Upload File Types
    public const ALLOWED_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    public const ALLOWED_DESIGN_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf', 'application/zip'];
    public const MAX_FILE_SIZE = 15 * 1024 * 1024; // 15 MB

    public static function init(): void
    {
        date_default_timezone_set(self::TIMEZONE);
        mb_internal_encoding('UTF-8');
    }
}
