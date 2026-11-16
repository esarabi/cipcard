<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Order
{
    public static function generateOrderNumber(): string
    {
        return 'CIP-' . date('Ym') . '-' . strtoupper(bin2hex(random_bytes(3)));
    }

    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $orderNumber = $data['order_number'] ?? self::generateOrderNumber();

        $stmt = $db->prepare("
            INSERT INTO orders (
                order_number, user_id, card_type, amount, status,
                custom_design_file, custom_design_notes, shipping_address, postal_code
            ) VALUES (
                :order_number, :user_id, :card_type, :amount, :status,
                :custom_design_file, :custom_design_notes, :shipping_address, :postal_code
            )
        ");

        $stmt->execute([
            ':order_number'        => $orderNumber,
            ':user_id'             => $data['user_id'],
            ':card_type'           => $data['card_type'],
            ':amount'              => $data['amount'],
            ':status'              => $data['status'] ?? 'unpaid',
            ':custom_design_file'  => $data['custom_design_file'] ?? null,
            ':custom_design_notes' => $data['custom_design_notes'] ?? null,
            ':shipping_address'    => $data['shipping_address'] ?? null,
            ':postal_code'         => $data['postal_code'] ?? null
        ]);

        return (int)$db->lastInsertId();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT o.*, u.full_name, u.mobile
            FROM orders o
            JOIN users u ON o.user_id = u.id
            WHERE o.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $order = $stmt->fetch();
        return $order ?: null;
    }

    public static function findByOrderNumber(string $orderNumber): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT o.*, u.full_name, u.mobile
            FROM orders o
            JOIN users u ON o.user_id = u.id
            WHERE o.order_number = :order_number
            LIMIT 1
        ");
        $stmt->execute([':order_number' => $orderNumber]);
        $order = $stmt->fetch();
        return $order ?: null;
    }

    public static function findByUserId(int $userId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT * FROM orders
            WHERE user_id = :user_id
            ORDER BY id DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function getLatestByUserId(int $userId): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT * FROM orders
            WHERE user_id = :user_id
            ORDER BY id DESC
            LIMIT 1
        ");
        $stmt->execute([':user_id' => $userId]);
        $order = $stmt->fetch();
        return $order ?: null;
    }

    public static function updateStatus(int $id, string $status, ?string $trackingCode = null): bool
    {
        $db = Database::getConnection();
        $sql = "UPDATE orders SET status = :status";
        $params = [':status' => $status, ':id' => $id];

        if ($trackingCode !== null) {
            $sql .= ", tracking_code = :tracking_code";
            $params[':tracking_code'] = $trackingCode;
        }

        if ($status === 'shipped') {
            $sql .= ", shipped_at = NOW()";
        }

        $sql .= " WHERE id = :id";
        return $db->prepare($sql)->execute($params);
    }

    public static function updateDesign(int $id, string $filePath, ?string $notes = null): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE orders
            SET custom_design_file = :file, custom_design_notes = :notes
            WHERE id = :id
        ");
        return $stmt->execute([
            ':file'  => $filePath,
            ':notes' => $notes,
            ':id'    => $id
        ]);
    }

    public static function getAllWithDetails(int $limit = 50, int $offset = 0, ?string $statusFilter = null): array
    {
        $db = Database::getConnection();
        $sql = "
            SELECT o.*, u.full_name, u.mobile, t.ref_id, t.status AS trans_status
            FROM orders o
            JOIN users u ON o.user_id = u.id
            LEFT JOIN transactions t ON o.id = t.order_id AND t.status = 'success'
        ";

        $params = [];
        if ($statusFilter !== null && $statusFilter !== '') {
            $sql .= " WHERE o.status = :status";
            $params[':status'] = $statusFilter;
        }

        $sql .= " ORDER BY o.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function countAll(?string $status = null): int
    {
        $db = Database::getConnection();
        if ($status !== null && $status !== '') {
            $stmt = $db->prepare("SELECT COUNT(*) FROM orders WHERE status = :status");
            $stmt->execute([':status' => $status]);
            return (int)$stmt->fetchColumn();
        }
        return (int)$db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    }

    public static function getTotalRevenue(): int
    {
        $db = Database::getConnection();
        return (int)$db->query("
            SELECT COALESCE(SUM(amount), 0)
            FROM orders
            WHERE status != 'unpaid' AND status != 'cancelled'
        ")->fetchColumn();
    }

    public static function getMonthlyRevenue(): int
    {
        $db = Database::getConnection();
        return (int)$db->query("
            SELECT COALESCE(SUM(amount), 0)
            FROM orders
            WHERE status != 'unpaid' AND status != 'cancelled'
              AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        ")->fetchColumn();
    }
}
