<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Helper;
use PDO;

class User
{
    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO users (mobile, full_name, role, password, status)
            VALUES (:mobile, :full_name, :role, :password, :status)
        ");
        $stmt->execute([
            ':mobile'    => $data['mobile'],
            ':full_name' => $data['full_name'],
            ':role'      => $data['role'] ?? 'user',
            ':password'  => isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : null,
            ':status'    => $data['status'] ?? 'pending_verification'
        ]);
        return (int)$db->lastInsertId();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function findByMobile(string $mobile): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE mobile = :mobile LIMIT 1");
        $stmt->execute([':mobile' => $mobile]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function findByUsernameOrMobile(string $identifier): ?array
    {
        $db = Database::getConnection();
        $clean = trim($identifier);

        // 1. Normalized Iranian mobile
        $normalizedMobile = Helper::normalizeMobile($clean);
        if ($normalizedMobile) {
            $user = self::findByMobile($normalizedMobile);
            if ($user) return $user;
        }

        // 2. Direct mobile or username match
        $stmt = $db->prepare("SELECT * FROM users WHERE mobile = :id1 OR (role = 'admin' AND :id2 = 'admin') LIMIT 1");
        $stmt->execute([':id1' => $clean, ':id2' => strtolower($clean)]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function update(int $id, array $data): bool
    {
        $db = Database::getConnection();
        $fields = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if ($key === 'id') continue;
            if ($key === 'password' && !empty($value)) {
                $fields[] = "password = :password";
                $params[':password'] = password_hash($value, PASSWORD_BCRYPT);
                continue;
            }
            $fields[] = "{$key} = :{$key}";
            $params[":{$key}"] = $value;
        }

        if (empty($fields)) return false;

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        return $db->prepare($sql)->execute($params);
    }

    public static function countAll(): int
    {
        $db = Database::getConnection();
        return (int)$db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public static function getAll(int $limit = 50, int $offset = 0): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT u.*, p.job_title, p.template_id, p.is_active AS profile_active
            FROM users u
            LEFT JOIN profiles p ON u.id = p.user_id
            ORDER BY u.id DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function search(string $term): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT u.*, p.job_title, p.is_active AS profile_active
            FROM users u
            LEFT JOIN profiles p ON u.id = p.user_id
            WHERE u.mobile LIKE :term OR u.full_name LIKE :term
            ORDER BY u.id DESC
            LIMIT 50
        ");
        $searchTerm = "%{$term}%";
        $stmt->execute([':term' => $searchTerm]);
        return $stmt->fetchAll();
    }
}
