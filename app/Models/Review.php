<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Review
{
    private static bool $schemaChecked = false;

    /**
     * Ensure profile_reviews table and enable_reviews column in profiles exist
     */
    public static function ensureSchema(): void
    {
        if (self::$schemaChecked) {
            return;
        }
        self::$schemaChecked = true;

        try {
            $db = Database::getConnection();

            // 1. Ensure enable_reviews column exists in profiles table
            $stmtCol = $db->query("SHOW COLUMNS FROM `profiles` LIKE 'enable_reviews'");
            if (!$stmtCol || !$stmtCol->fetch()) {
                $db->exec("ALTER TABLE `profiles` ADD COLUMN `enable_reviews` TINYINT(1) NOT NULL DEFAULT 1 AFTER `more_info_title`");
            }

            // 2. Ensure profile_reviews table exists
            $tableCheck = $db->query("SHOW TABLES LIKE 'profile_reviews'");
            if (!$tableCheck || !$tableCheck->fetch()) {
                $sql = "
                    CREATE TABLE IF NOT EXISTS `profile_reviews` (
                        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                        `profile_id` BIGINT UNSIGNED NOT NULL,
                        `author_name` VARCHAR(150) NOT NULL,
                        `author_mobile` VARCHAR(50) NULL,
                        `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5,
                        `comment` TEXT NOT NULL,
                        `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
                        `owner_reply` TEXT NULL,
                        `replied_at` DATETIME NULL,
                        `ip_address` VARCHAR(45) NULL,
                        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`),
                        INDEX `idx_reviews_profile_status` (`profile_id`, `status`),
                        INDEX `idx_reviews_created` (`created_at`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ";
                $db->exec($sql);
            }
        } catch (PDOException $e) {
            error_log("Review ensureSchema Error: " . $e->getMessage());
        }
    }

    /**
     * Create a new review (defaults to status 'pending')
     */
    public static function create(array $data): int
    {
        self::ensureSchema();
        $db = Database::getConnection();

        $rating = (int)($data['rating'] ?? 5);
        if ($rating < 1) $rating = 1;
        if ($rating > 5) $rating = 5;

        $stmt = $db->prepare("
            INSERT INTO profile_reviews (
                profile_id, author_name, author_mobile, rating, comment, status, ip_address
            ) VALUES (
                :profile_id, :author_name, :author_mobile, :rating, :comment, 'pending', :ip_address
            )
        ");

        $stmt->execute([
            ':profile_id'    => (int)$data['profile_id'],
            ':author_name'   => trim((string)$data['author_name']),
            ':author_mobile' => !empty($data['author_mobile']) ? trim((string)$data['author_mobile']) : null,
            ':rating'        => $rating,
            ':comment'       => trim((string)$data['comment']),
            ':ip_address'    => $data['ip_address'] ?? null
        ]);

        return (int)$db->lastInsertId();
    }

    /**
     * Find review by ID
     */
    public static function findById(int $id): ?array
    {
        self::ensureSchema();
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM profile_reviews WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    /**
     * Get approved reviews for public profile
     */
    public static function getApprovedByProfileId(int $profileId, int $limit = 50): array
    {
        self::ensureSchema();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT * FROM profile_reviews 
            WHERE profile_id = :pid AND status = 'approved'
            ORDER BY id DESC
            LIMIT :lim
        ");
        $stmt->bindValue(':pid', $profileId, PDO::PARAM_INT);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Get aggregated review stats for a profile (average rating, total approved count, star breakdown)
     */
    public static function getStatsByProfileId(int $profileId): array
    {
        self::ensureSchema();
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT 
                COUNT(*) as total_count,
                AVG(rating) as avg_rating,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as stars_5,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as stars_4,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as stars_3,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as stars_2,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as stars_1
            FROM profile_reviews
            WHERE profile_id = :pid AND status = 'approved'
        ");
        $stmt->execute([':pid' => $profileId]);
        $row = $stmt->fetch() ?: [];

        $total = (int)($row['total_count'] ?? 0);
        $avg = $total > 0 ? round((float)($row['avg_rating'] ?? 5.0), 1) : 5.0;

        return [
            'total_reviews'  => $total,
            'average_rating' => $avg,
            'star_counts'    => [
                5 => (int)($row['stars_5'] ?? 0),
                4 => (int)($row['stars_4'] ?? 0),
                3 => (int)($row['stars_3'] ?? 0),
                2 => (int)($row['stars_2'] ?? 0),
                1 => (int)($row['stars_1'] ?? 0),
            ]
        ];
    }

    /**
     * Get all reviews for a profile (for owner dashboard), optionally filtered by status
     */
    public static function getAllByProfileId(int $profileId, ?string $status = null): array
    {
        self::ensureSchema();
        $db = Database::getConnection();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $stmt = $db->prepare("
                SELECT * FROM profile_reviews 
                WHERE profile_id = :pid AND status = :st
                ORDER BY id DESC
            ");
            $stmt->execute([':pid' => $profileId, ':st' => $status]);
        } else {
            $stmt = $db->prepare("
                SELECT * FROM profile_reviews 
                WHERE profile_id = :pid
                ORDER BY id DESC
            ");
            $stmt->execute([':pid' => $profileId]);
        }

        return $stmt->fetchAll() ?: [];
    }

    /**
     * Get review counts by status for owner dashboard
     */
    public static function getCountsByProfileId(int $profileId): array
    {
        self::ensureSchema();
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT 
                COUNT(*) as all_count,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_count,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_count
            FROM profile_reviews
            WHERE profile_id = :pid
        ");
        $stmt->execute([':pid' => $profileId]);
        $row = $stmt->fetch() ?: [];

        return [
            'all'      => (int)($row['all_count'] ?? 0),
            'pending'  => (int)($row['pending_count'] ?? 0),
            'approved' => (int)($row['approved_count'] ?? 0),
            'rejected' => (int)($row['rejected_count'] ?? 0),
        ];
    }

    /**
     * Count pending reviews for notification badges
     */
    public static function countPendingByProfileId(int $profileId): int
    {
        self::ensureSchema();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM profile_reviews 
            WHERE profile_id = :pid AND status = 'pending'
        ");
        $stmt->execute([':pid' => $profileId]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Update review status (approved, rejected, pending)
     */
    public static function updateStatus(int $id, int $profileId, string $status): bool
    {
        if (!in_array($status, ['approved', 'rejected', 'pending'], true)) {
            return false;
        }

        self::ensureSchema();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE profile_reviews 
            SET status = :status 
            WHERE id = :id AND profile_id = :pid
        ");
        return $stmt->execute([
            ':status' => $status,
            ':id'     => $id,
            ':pid'    => $profileId
        ]);
    }

    /**
     * Save or update owner reply
     */
    public static function saveReply(int $id, int $profileId, string $replyText): bool
    {
        self::ensureSchema();
        $db = Database::getConnection();
        $cleanReply = trim($replyText);

        $stmt = $db->prepare("
            UPDATE profile_reviews 
            SET owner_reply = :reply, 
                replied_at = :replied_at
            WHERE id = :id AND profile_id = :pid
        ");
        return $stmt->execute([
            ':reply'      => $cleanReply !== '' ? $cleanReply : null,
            ':replied_at' => $cleanReply !== '' ? date('Y-m-d H:i:s') : null,
            ':id'         => $id,
            ':pid'        => $profileId
        ]);
    }

    /**
     * Delete a review
     */
    public static function delete(int $id, int $profileId): bool
    {
        self::ensureSchema();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            DELETE FROM profile_reviews 
            WHERE id = :id AND profile_id = :pid
        ");
        return $stmt->execute([':id' => $id, ':pid' => $profileId]);
    }
}
