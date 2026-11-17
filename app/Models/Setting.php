<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Setting
{
    private static array $cache = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT value FROM settings WHERE key_name = :key LIMIT 1");
            $stmt->execute([':key' => $key]);
            $val = $stmt->fetchColumn();

            if ($val !== false && $val !== null) {
                self::$cache[$key] = $val;
                return $val;
            }
        } catch (\Throwable $e) {
            error_log("Setting::get Error ({$key}): " . $e->getMessage());
        }

        return $default;
    }

    public static function set(string $key, mixed $value): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO settings (key_name, value, title, group_name)
            VALUES (:key, :val, :key2, 'general')
            ON DUPLICATE KEY UPDATE value = :val2
        ");
        $success = $stmt->execute([
            ':key'  => $key,
            ':val'  => (string)$value,
            ':key2' => $key,
            ':val2' => (string)$value
        ]);

        if ($success) {
            self::$cache[$key] = (string)$value;
        }
        return $success;
    }

    public static function getAll(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM settings ORDER BY group_name, id ASC");
        return $stmt->fetchAll();
    }

    public static function getAllGrouped(): array
    {
        $items = self::getAll();
        $grouped = [];
        foreach ($items as $item) {
            $grouped[$item['group_name']][] = $item;
        }
        return $grouped;
    }

    public static function updateMultiple(array $settings): bool
    {
        $db = Database::getConnection();
        $db->beginTransaction();
        try {
            $stmt = $db->prepare("
                INSERT INTO settings (key_name, value, title, group_name)
                VALUES (:key, :val, :title, 'general')
                ON DUPLICATE KEY UPDATE value = :val2
            ");
            foreach ($settings as $key => $val) {
                $stmt->execute([
                    ':key'   => $key,
                    ':val'   => (string)$val,
                    ':title' => $key,
                    ':val2'  => (string)$val
                ]);
                self::$cache[$key] = (string)$val;
            }
            $db->commit();
            return true;
        } catch (\Throwable $e) {
            $db->rollBack();
            error_log("Setting::updateMultiple Error: " . $e->getMessage());
            return false;
        }
    }
}
