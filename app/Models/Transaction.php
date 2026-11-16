<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Transaction
{
    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO transactions (order_id, user_id, authority, amount, gateway, status)
            VALUES (:order_id, :user_id, :authority, :amount, :gateway, :status)
        ");
        $stmt->execute([
            ':order_id'  => $data['order_id'],
            ':user_id'   => $data['user_id'],
            ':authority' => $data['authority'],
            ':amount'    => $data['amount'],
            ':gateway'   => $data['gateway'] ?? 'zarinpal',
            ':status'    => $data['status'] ?? 'pending'
        ]);
        return (int)$db->lastInsertId();
    }

    public static function findByAuthority(string $authority): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT t.*, o.order_number, o.card_type, u.mobile, u.full_name
            FROM transactions t
            JOIN orders o ON t.order_id = o.id
            JOIN users u ON t.user_id = u.id
            WHERE t.authority = :authority
            LIMIT 1
        ");
        $stmt->execute([':authority' => $authority]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function updateStatus(
        int $id,
        string $status,
        ?string $refId = null,
        ?string $cardPan = null,
        int $fee = 0,
        ?string $errorMessage = null
    ): bool {
        $db = Database::getConnection();
        $sql = "
            UPDATE transactions
            SET status = :status,
                ref_id = :ref_id,
                card_pan = :card_pan,
                fee = :fee,
                error_message = :error_message,
                payment_date = " . ($status === 'success' ? 'NOW()' : 'payment_date') . "
            WHERE id = :id
        ";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':status'        => $status,
            ':ref_id'        => $refId,
            ':card_pan'      => $cardPan,
            ':fee'           => $fee,
            ':error_message' => $errorMessage,
            ':id'            => $id
        ]);
    }

    public static function getAllWithDetails(int $limit = 50, int $offset = 0): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT t.*, o.order_number, u.full_name, u.mobile
            FROM transactions t
            JOIN orders o ON t.order_id = o.id
            JOIN users u ON t.user_id = u.id
            ORDER BY t.id DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getChartDataLast30Days(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT
                DATE(created_at) AS date_day,
                COUNT(id) AS total_count,
                COALESCE(SUM(CASE WHEN status = 'success' THEN amount ELSE 0 END), 0) AS total_revenue
            FROM transactions
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
            GROUP BY DATE(created_at)
            ORDER BY date_day ASC
        ");
        return $stmt->fetchAll();
    }
}
