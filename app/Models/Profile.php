<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Profile
{
    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO profiles (
                user_id, slug, display_name, job_title, company, bio,
                avatar_url, cover_url, email, phone_work, phone_mobile,
                website, address, social_links, template_id, theme_color, is_active
            ) VALUES (
                :user_id, :slug, :display_name, :job_title, :company, :bio,
                :avatar_url, :cover_url, :email, :phone_work, :phone_mobile,
                :website, :address, :social_links, :template_id, :theme_color, :is_active
            )
        ");

        $social = isset($data['social_links']) && is_array($data['social_links'])
            ? json_encode($data['social_links'], JSON_UNESCAPED_UNICODE)
            : ($data['social_links'] ?? null);

        $stmt->execute([
            ':user_id'      => $data['user_id'],
            ':slug'         => $data['slug'] ?? null,
            ':display_name' => $data['display_name'],
            ':job_title'    => $data['job_title'] ?? null,
            ':company'      => $data['company'] ?? null,
            ':bio'          => $data['bio'] ?? null,
            ':avatar_url'   => $data['avatar_url'] ?? null,
            ':cover_url'    => $data['cover_url'] ?? null,
            ':email'        => $data['email'] ?? null,
            ':phone_work'   => $data['phone_work'] ?? null,
            ':phone_mobile' => $data['phone_mobile'] ?? null,
            ':website'      => $data['website'] ?? null,
            ':address'      => $data['address'] ?? null,
            ':social_links' => $social,
            ':template_id'  => $data['template_id'] ?? 'minimal',
            ':theme_color'  => $data['theme_color'] ?? 'gold_black',
            ':is_active'    => $data['is_active'] ?? 0
        ]);

        return (int)$db->lastInsertId();
    }

    public static function findByUserId(int $userId): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM profiles WHERE user_id = :user_id LIMIT 1");
        $stmt->execute([':user_id' => $userId]);
        $profile = $stmt->fetch();
        if ($profile && !empty($profile['social_links'])) {
            $profile['social_links'] = json_decode($profile['social_links'], true) ?: [];
        }
        return $profile ?: null;
    }

    public static function findByMobile(string $mobile): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT p.*, u.mobile, u.status AS user_status, u.full_name AS user_full_name
            FROM profiles p
            JOIN users u ON p.user_id = u.id
            WHERE u.mobile = :mobile OR p.slug = :mobile2
            LIMIT 1
        ");
        $stmt->execute([':mobile' => $mobile, ':mobile2' => $mobile]);
        $profile = $stmt->fetch();
        if ($profile && !empty($profile['social_links'])) {
            $profile['social_links'] = json_decode($profile['social_links'], true) ?: [];
        }
        return $profile ?: null;
    }

    public static function updateByUserId(int $userId, array $data): bool
    {
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

            $fields[] = "{$key} = :{$key}";
            $params[":{$key}"] = $value;
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
