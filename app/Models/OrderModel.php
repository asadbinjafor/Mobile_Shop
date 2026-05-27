<?php
namespace App\Models;

use App\Core\Database;

class OrderModel
{
    public static function create(int $userId, array $cart, array $shipping, string $payment = 'cod'): string
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['qty'];
            }
            $orderNumber = 'MH' . date('ymd') . strtoupper(substr(uniqid(), -5));

            $stmt = $pdo->prepare(
                'INSERT INTO orders (user_id, order_number, subtotal, total, payment_method, shipping_name, shipping_phone, shipping_address)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                $userId,
                $orderNumber,
                $subtotal,
                $subtotal,
                $payment,
                $shipping['name'],
                $shipping['phone'],
                $shipping['address'],
            ]);
            $orderId = (int) $pdo->lastInsertId();

            $itemStmt = $pdo->prepare(
                'INSERT INTO order_items (order_id, product_id, product_name, price, qty) VALUES (?, ?, ?, ?, ?)'
            );
            foreach ($cart as $item) {
                $itemStmt->execute([$orderId, $item['id'], $item['name'], $item['price'], $item['qty']]);
                $pdo->prepare('UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?')
                    ->execute([$item['qty'], $item['id'], $item['qty']]);
            }

            $pdo->commit();
            return $orderNumber;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function all(): array
    {
        return Database::connection()->query(
            'SELECT o.*, u.name as customer_name, u.email as customer_email
             FROM orders o JOIN users u ON u.id = o.user_id
             ORDER BY o.id DESC'
        )->fetchAll();
    }

    public static function byUser(int $userId): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM orders WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function items(int $orderId): array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM order_items WHERE order_id = ?');
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    public static function updateStatus(int $id, string $status): void
    {
        Database::connection()->prepare('UPDATE orders SET status = ? WHERE id = ?')->execute([$status, $id]);
    }

    public static function stats(): array
    {
        $pdo = Database::connection();
        $totalRevenue = (int) $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status != 'cancelled'")->fetchColumn();
        $totalOrders = (int) $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
        $pending = (int) $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
        $monthly = $pdo->query(
            "SELECT DATE_FORMAT(created_at,'%Y-%m') as month, SUM(total) as revenue, COUNT(*) as orders
             FROM orders WHERE status != 'cancelled'
             GROUP BY month ORDER BY month DESC LIMIT 6"
        )->fetchAll();
        return compact('totalRevenue', 'totalOrders', 'pending', 'monthly');
    }
}
