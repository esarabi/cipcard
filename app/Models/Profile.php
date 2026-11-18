<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Profile
{
    private static bool $schemaChecked = false;

    /**
     * Reserved system slugs that cannot be registered by users
     */
    public const RESERVED_SLUGS = [
        'admin', 'api', 'auth', 'dashboard', 'order', 'orders', 'vcard', 'qr',
        'login', 'logout', 'payment', 'home', 'public', 'assets', 'uploads',
        'terms', 'privacy', 'help', 'support', 'contact', 'about', 'cipcard',
        'rastin', 'rastingroup', 'settings', 'profile', 'user', 'users', 'download',
        'index', 'feed', 'sitemap', 'robot', 'robots', 'null', 'undefined'
    ];

    /**
     * Ensure `more_info` column exists on existing production databases automatically
     */
    public static function ensureExtendedColumns(): void
    {
        if (self::$schemaChecked) {
            return;
        }
        self::$schemaChecked = true;

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SHOW COLUMNS FROM `profiles` LIKE 'more_info'");
            if (!$stmt || !$stmt->fetch()) {
                $db->exec("ALTER TABLE `profiles` ADD COLUMN `more_info` LONGTEXT NULL AFTER `bio`");
            }
            $stmt2 = $db->query("SHOW COLUMNS FROM `profiles` LIKE 'more_info_title'");
            if (!$stmt2 || !$stmt2->fetch()) {
                $db->exec("ALTER TABLE `profiles` ADD COLUMN `more_info_title` VARCHAR(255) NULL AFTER `more_info`");
            }
            $stmt3 = $db->query("SHOW COLUMNS FROM `profiles` LIKE 'enable_reviews'");
            if (!$stmt3 || !$stmt3->fetch()) {
                $db->exec("ALTER TABLE `profiles` ADD COLUMN `enable_reviews` TINYINT(1) NOT NULL DEFAULT 1 AFTER `more_info_title`");
            }
            $stmt4 = $db->query("SHOW COLUMNS FROM `profiles` LIKE 'featured_image_url'");
            if (!$stmt4 || !$stmt4->fetch()) {
                $db->exec("ALTER TABLE `profiles` ADD COLUMN `featured_image_url` VARCHAR(255) NULL AFTER `cover_url`");
            }
            $stmt5 = $db->query("SHOW COLUMNS FROM `profiles` LIKE 'featured_image_title'");
            if (!$stmt5 || !$stmt5->fetch()) {
                $db->exec("ALTER TABLE `profiles` ADD COLUMN `featured_image_title` VARCHAR(255) NULL AFTER `featured_image_url`");
            }
            Review::ensureSchema();
        } catch (PDOException $e) {
            // Silently ignore if table does not exist or permission is restricted
        }
    }

    public static function create(array $data): int
    {
        self::ensureExtendedColumns();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO profiles (
                user_id, slug, display_name, job_title, company, bio, more_info, more_info_title, enable_reviews,
                avatar_url, cover_url, featured_image_url, featured_image_title, email, phone_work, phone_mobile,
                website, address, map_link, map_latitude, map_longitude,
                working_days, working_hours, working_note, default_lang,
                social_links, template_id, theme_color, theme_mode, is_active
            ) VALUES (
                :user_id, :slug, :display_name, :job_title, :company, :bio, :more_info, :more_info_title, :enable_reviews,
                :avatar_url, :cover_url, :featured_image_url, :featured_image_title, :email, :phone_work, :phone_mobile,
                :website, :address, :map_link, :map_latitude, :map_longitude,
                :working_days, :working_hours, :working_note, :default_lang,
                :social_links, :template_id, :theme_color, :theme_mode, :is_active
            )
        ");

        $social = isset($data['social_links']) && is_array($data['social_links'])
            ? json_encode($data['social_links'], JSON_UNESCAPED_UNICODE)
            : ($data['social_links'] ?? null);

        $stmt->execute([
            ':user_id'       => $data['user_id'],
            ':slug'          => !empty($data['slug']) ? strtolower(trim((string)$data['slug'])) : null,
            ':display_name'  => $data['display_name'],
            ':job_title'     => $data['job_title'] ?? null,
            ':company'       => $data['company'] ?? null,
            ':bio'           => $data['bio'] ?? null,
            ':more_info'     => $data['more_info'] ?? null,
            ':more_info_title' => $data['more_info_title'] ?? null,
            ':enable_reviews'  => isset($data['enable_reviews']) ? (int)$data['enable_reviews'] : 1,
            ':avatar_url'    => $data['avatar_url'] ?? null,
            ':cover_url'     => $data['cover_url'] ?? null,
            ':featured_image_url'   => $data['featured_image_url'] ?? null,
            ':featured_image_title' => $data['featured_image_title'] ?? null,
            ':email'         => $data['email'] ?? null,
            ':phone_work'    => $data['phone_work'] ?? null,
            ':phone_mobile'  => $data['phone_mobile'] ?? null,
            ':website'       => $data['website'] ?? null,
            ':address'       => $data['address'] ?? null,
            ':map_link'      => $data['map_link'] ?? null,
            ':map_latitude'  => !empty($data['map_latitude']) ? (float)$data['map_latitude'] : null,
            ':map_longitude' => !empty($data['map_longitude']) ? (float)$data['map_longitude'] : null,
            ':working_days'  => $data['working_days'] ?? null,
            ':working_hours' => $data['working_hours'] ?? null,
            ':working_note'  => $data['working_note'] ?? null,
            ':default_lang'  => !empty($data['default_lang']) ? $data['default_lang'] : 'fa',
            ':social_links'  => $social,
            ':template_id'   => $data['template_id'] ?? 'minimal',
            ':theme_color'   => $data['theme_color'] ?? 'gold_black',
            ':theme_mode'    => $data['theme_mode'] ?? 'light',
            ':is_active'     => $data['is_active'] ?? 0
        ]);

        return (int)$db->lastInsertId();
    }

    public static function findByUserId(int $userId): ?array
    {
        self::ensureExtendedColumns();
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM profiles WHERE user_id = :user_id LIMIT 1");
        $stmt->execute([':user_id' => $userId]);
        $profile = $stmt->fetch();
        if ($profile && !empty($profile['social_links'])) {
            $profile['social_links'] = json_decode($profile['social_links'], true) ?: [];
        }
        return $profile ?: null;
    }

    /**
     * Find profile by Mobile or custom Slug (case-insensitive)
     */
    public static function findByMobile(string $identifier): ?array
    {
        self::ensureExtendedColumns();
        $db = Database::getConnection();
        $clean = trim($identifier);

        $stmt = $db->prepare("
            SELECT p.*, u.mobile, u.status AS user_status, u.full_name AS user_full_name
            FROM profiles p
            JOIN users u ON p.user_id = u.id
            WHERE u.mobile = :mobile OR LOWER(p.slug) = LOWER(:slug)
            LIMIT 1
        ");
        $stmt->execute([
            ':mobile' => $clean,
            ':slug'   => $clean
        ]);
        $profile = $stmt->fetch();
        if ($profile && !empty($profile['social_links'])) {
            $profile['social_links'] = json_decode($profile['social_links'], true) ?: [];
        }
        return $profile ?: null;
    }

    /**
     * Check if a custom slug is valid and available for reservation
     */
    public static function isSlugAvailable(string $slug, int $excludeUserId = 0): bool
    {
        $slug = strtolower(trim($slug));

        // Format validation: 3 to 40 alphanumeric characters, hyphens, underscores or dots
        if (!preg_match('/^[a-z0-9_\-\.]{3,40}$/', $slug)) {
            return false;
        }

        // Cannot be reserved word
        if (in_array($slug, self::RESERVED_SLUGS, true)) {
            return false;
        }

        $db = Database::getConnection();

        // Ensure not colliding with any other user's mobile number
        $stmtMobile = $db->prepare("SELECT id FROM users WHERE mobile = :mobile AND id != :uid LIMIT 1");
        $stmtMobile->execute([':mobile' => $slug, ':uid' => $excludeUserId]);
        if ($stmtMobile->fetch()) {
            return false;
        }

        // Ensure not already used in profiles.slug
        $stmtSlug = $db->prepare("SELECT id FROM profiles WHERE LOWER(slug) = LOWER(:slug) AND user_id != :uid LIMIT 1");
        $stmtSlug->execute([':slug' => $slug, ':uid' => $excludeUserId]);
        if ($stmtSlug->fetch()) {
            return false;
        }

        return true;
    }

    public static function updateByUserId(int $userId, array $data): bool
    {
        self::ensureExtendedColumns();
        $db = Database::getConnection();
        $fields = [];
        $params = [':user_id' => $userId];

        foreach ($data as $key => $value) {
            if ($key === 'id' || $key === 'user_id') continue;

            if ($key === 'social_links' && is_array($value)) {
                $fields[] = "social_links = :social_links";
                $params[':social_links'] = json_encode($value, JSON_UNESCAPED_UNICODE);
                continue;
            }

            if ($key === 'slug') {
                $trimmed = strtolower(trim((string)$value));
                $fields[] = "slug = :slug";
                $params[':slug'] = !empty($trimmed) ? $trimmed : null;
                continue;
            }

            if (in_array($key, ['map_latitude', 'map_longitude'], true)) {
                $fields[] = "{$key} = :{$key}";
                $params[":{$key}"] = (is_numeric($value) && (float)$value != 0) ? (float)$value : null;
                continue;
            }

            $fields[] = "{$key} = :{$key}";
            $params[":{$key}"] = ($value === '' ? null : $value);
        }

        if (empty($fields)) return false;

        $sql = "UPDATE profiles SET " . implode(', ', $fields) . " WHERE user_id = :user_id";
        return $db->prepare($sql)->execute($params);
    }

    public static function incrementViews(int $id): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE profiles SET view_count = view_count + 1 WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
