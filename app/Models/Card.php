<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use Exception;

class Card
{
    private static bool $schemaChecked = false;

    /**
     * Ensure the `cards` table exists on the database
     */
    public static function ensureTable(): void
    {
        if (self::$schemaChecked) {
            return;
        }
        self::$schemaChecked = true;

        try {
            $db = Database::getConnection();
            $db->exec("
                CREATE TABLE IF NOT EXISTS `cards` (
                  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                  `card_code` VARCHAR(32) NOT NULL UNIQUE COMMENT 'Unique card code e.g. CIP-7K9M2P',
                  `batch_name` VARCHAR(150) NULL COMMENT 'Batch identifier e.g. چاپ سری اول آذر ۱۴۰۵',
                  `user_id` BIGINT UNSIGNED NULL COMMENT 'Linked user id or NULL if unassigned',
                  `profile_id` BIGINT UNSIGNED NULL COMMENT 'Linked profile id or NULL if unassigned',
                  `status` ENUM('unassigned', 'assigned', 'blocked') NOT NULL DEFAULT 'unassigned' COMMENT 'Card state',
                  `assigned_at` DATETIME NULL COMMENT 'Timestamp when linked to user',
                  `notes` VARCHAR(255) NULL COMMENT 'Admin notes e.g. متالیک مشکی مات',
                  `scan_count` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Number of scans/visits',
                  `last_scanned_at` DATETIME NULL COMMENT 'Last scan timestamp',
                  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `idx_cards_code` (`card_code`),
                  INDEX `idx_cards_user_id` (`user_id`),
                  INDEX `idx_cards_profile_id` (`profile_id`),
                  INDEX `idx_cards_status` (`status`),
                  INDEX `idx_cards_batch` (`batch_name`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        } catch (Exception $e) {
            // Silently catch or log table creation errors
        }
    }

    /**
     * Generate unique, human-friendly random code (omits ambiguous characters: 0, O, 1, I, L)
     */
    public static function generateRandomCode(string $prefix = 'CIP-', int $length = 6): string
    {
        $alphabet = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';
        $alphaLen = strlen($alphabet);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $alphabet[random_int(0, $alphaLen - 1)];
        }
        return strtoupper($prefix . $result);
    }

    /**
     * Bulk generate unassigned QR cards in database
     *
     * @param int $count Number of cards to create
     * @param string $batchName Optional name of batch (e.g. چاپ سری اول)
     * @param string $prefix Code prefix (e.g. CIP-)
     * @param string $notes Optional notes (e.g. کارت طلایی متالیک)
     * @param int $codeLength Length of random suffix
     * @return array List of generated card codes and total count
     */
    public static function bulkGenerate(
        int $count,
        string $batchName = '',
        string $prefix = 'CIP-',
        string $notes = '',
        int $codeLength = 6
    ): array {
        self::ensureTable();
        $db = Database::getConnection();

        $count = max(1, min(1000, $count)); // Limit between 1 and 1000 per request
        $prefix = trim($prefix) !== '' ? strtoupper(trim($prefix)) : 'CIP-';
        $batchName = trim($batchName) !== '' ? trim($batchName) : ('دسته تولید ' . date('Y-m-d H:i'));

        $generatedCodes = [];
        $insertedCount = 0;

        $stmtCheck = $db->prepare("SELECT id FROM cards WHERE card_code = :code LIMIT 1");
        $stmtInsert = $db->prepare("
            INSERT INTO cards (card_code, batch_name, status, notes)
            VALUES (:card_code, :batch_name, 'unassigned', :notes)
        ");

        $db->beginTransaction();
        try {
            while ($insertedCount < $count) {
                $code = self::generateRandomCode($prefix, $codeLength);

                // Ensure uniqueness
                $stmtCheck->execute([':code' => $code]);
                if ($stmtCheck->fetch()) {
                    continue; // Collision, generate another
                }

                $stmtInsert->execute([
                    ':card_code'  => $code,
                    ':batch_name' => $batchName,
                    ':notes'      => $notes !== '' ? $notes : null
                ]);

                $generatedCodes[] = $code;
                $insertedCount++;
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        return [
            'count'      => $insertedCount,
            'batch_name' => $batchName,
            'codes'      => $generatedCodes
        ];
    }

    /**
     * Find card by ID
     */
    public static function findById(int $id): ?array
    {
        self::ensureTable();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT c.*, u.mobile as user_mobile, u.full_name as user_full_name,
                   p.slug as profile_slug, p.display_name as profile_display_name
            FROM cards c
            LEFT JOIN users u ON u.id = c.user_id
            LEFT JOIN profiles p ON p.id = c.profile_id
            WHERE c.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $card = $stmt->fetch();
        return $card ?: null;
    }

    /**
     * Find card by its unique Code (e.g. CIP-7K9M2P)
     */
    public static function findByCode(string $code): ?array
    {
        self::ensureTable();
        $db = Database::getConnection();
        $cleanCode = strtoupper(trim($code));
        $stmt = $db->prepare("
            SELECT c.*, u.mobile as user_mobile, u.full_name as user_full_name,
                   p.slug as profile_slug, p.display_name as profile_display_name, p.is_active as profile_active
            FROM cards c
            LEFT JOIN users u ON u.id = c.user_id
            LEFT JOIN profiles p ON p.id = c.profile_id
            WHERE c.card_code = :code
            LIMIT 1
        ");
        $stmt->execute([':code' => $cleanCode]);
        $card = $stmt->fetch();
        return $card ?: null;
    }

    /**
     * Assign card to user and their profile
     */
    public static function assignToUser(int $cardId, int $userId): bool
    {
        self::ensureTable();
        $db = Database::getConnection();

        // Find user's profile
        $user = User::findById($userId);
        if (!$user) {
            return false;
        }

        $profile = Profile::findByUserId($userId);
        $profileId = $profile ? (int)$profile['id'] : null;

        $stmt = $db->prepare("
            UPDATE cards
            SET user_id = :user_id,
                profile_id = :profile_id,
                status = 'assigned',
                assigned_at = NOW()
            WHERE id = :id
        ");
        return $stmt->execute([
            ':user_id'    => $userId,
            ':profile_id' => $profileId,
            ':id'         => $cardId
        ]);
    }

    /**
     * Assign card by Code directly
     */
    public static function assignCodeToUser(string $code, int $userId): bool
    {
        $card = self::findByCode($code);
        if (!$card) {
            return false;
        }
        return self::assignToUser((int)$card['id'], $userId);
    }

    /**
     * Unbind card from user (resets status to unassigned)
     */
    public static function unbind(int $cardId): bool
    {
        self::ensureTable();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE cards
            SET user_id = NULL,
                profile_id = NULL,
                status = 'unassigned',
                assigned_at = NULL
            WHERE id = :id
        ");
        return $stmt->execute([':id' => $cardId]);
    }

    /**
     * Update card status (unassigned, assigned, blocked)
     */
    public static function updateStatus(int $cardId, string $status): bool
    {
        self::ensureTable();
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE cards SET status = :status WHERE id = :id");
        return $stmt->execute([
            ':status' => in_array($status, ['unassigned', 'assigned', 'blocked'], true) ? $status : 'unassigned',
            ':id'     => $cardId
        ]);
    }

    /**
     * Record scan event
     */
    public static function recordScan(int $cardId): void
    {
        self::ensureTable();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE cards
            SET scan_count = scan_count + 1,
                last_scanned_at = NOW()
            WHERE id = :id
        ");
        $stmt->execute([':id' => $cardId]);
    }

    /**
     * Delete an unassigned card
     */
    public static function delete(int $cardId): bool
    {
        self::ensureTable();
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM cards WHERE id = :id AND status = 'unassigned'");
        return $stmt->execute([':id' => $cardId]);
    }

    /**
     * Get cards assigned to a specific user
     */
    public static function getByUserId(int $userId): array
    {
        self::ensureTable();
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT * FROM cards
            WHERE user_id = :user_id
            ORDER BY id DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Get list of cards with optional filters and search
     */
    public static function getAll(int $limit = 50, int $offset = 0, array $filters = []): array
    {
        self::ensureTable();
        $db = Database::getConnection();

        $sql = "
            SELECT c.*, u.mobile as user_mobile, u.full_name as user_full_name,
                   p.slug as profile_slug, p.display_name as profile_display_name
            FROM cards c
            LEFT JOIN users u ON u.id = c.user_id
            LEFT JOIN profiles p ON p.id = c.profile_id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND c.status = :status";
            $params[':status'] = $filters['status'];
        }

        if (!empty($filters['batch_name'])) {
            $sql .= " AND c.batch_name = :batch_name";
            $params[':batch_name'] = $filters['batch_name'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (c.card_code LIKE :q OR c.batch_name LIKE :q OR u.mobile LIKE :q OR u.full_name LIKE :q OR p.slug LIKE :q)";
            $params[':q'] = '%' . $filters['search'] . '%';
        }

        $sql .= " ORDER BY c.id DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Count total cards matching filters
     */
    public static function countAll(array $filters = []): int
    {
        self::ensureTable();
        $db = Database::getConnection();

        $sql = "
            SELECT COUNT(*) FROM cards c
            LEFT JOIN users u ON u.id = c.user_id
            LEFT JOIN profiles p ON p.id = c.profile_id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND c.status = :status";
            $params[':status'] = $filters['status'];
        }

        if (!empty($filters['batch_name'])) {
            $sql .= " AND c.batch_name = :batch_name";
            $params[':batch_name'] = $filters['batch_name'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (c.card_code LIKE :q OR c.batch_name LIKE :q OR u.mobile LIKE :q OR u.full_name LIKE :q OR p.slug LIKE :q)";
            $params[':q'] = '%' . $filters['search'] . '%';
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Get aggregate statistics for dashboard
     */
    public static function getStats(): array
    {
        self::ensureTable();
        $db = Database::getConnection();

        $stmt = $db->query("
            SELECT
                COUNT(*) as total,
                SUM(CASE WHEN status = 'unassigned' THEN 1 ELSE 0 END) as unassigned,
                SUM(CASE WHEN status = 'assigned' THEN 1 ELSE 0 END) as assigned,
                SUM(CASE WHEN status = 'blocked' THEN 1 ELSE 0 END) as blocked,
                COALESCE(SUM(scan_count), 0) as total_scans
            FROM cards
        ");
        $stats = $stmt ? $stmt->fetch() : null;

        return [
            'total'       => (int)($stats['total'] ?? 0),
            'unassigned'  => (int)($stats['unassigned'] ?? 0),
            'assigned'    => (int)($stats['assigned'] ?? 0),
            'blocked'     => (int)($stats['blocked'] ?? 0),
            'total_scans' => (int)($stats['total_scans'] ?? 0)
        ];
    }

    /**
     * Get distinct batches for filter dropdown
     */
    public static function getBatches(): array
    {
        self::ensureTable();
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT
                batch_name,
                COUNT(*) as total_count,
                SUM(CASE WHEN status = 'assigned' THEN 1 ELSE 0 END) as assigned_count,
                SUM(CASE WHEN status = 'unassigned' THEN 1 ELSE 0 END) as unassigned_count,
                MIN(created_at) as created_at
            FROM cards
            WHERE batch_name IS NOT NULL AND batch_name != ''
            GROUP BY batch_name
            ORDER BY MIN(created_at) DESC
        ");
        return $stmt ? ($stmt->fetchAll() ?: []) : [];
    }
}
