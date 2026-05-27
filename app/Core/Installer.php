<?php
namespace App\Core;

use PDO;

class Installer
{
    public static function run(): array
    {
        $cfg = require ROOT_PATH . '/config/database.php';
        $pdo = new PDO(
            sprintf('mysql:host=%s;port=%d;charset=utf8mb4', $cfg['host'], $cfg['port']),
            $cfg['username'],
            $cfg['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . $cfg['database'] . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        $pdo->exec('USE `' . $cfg['database'] . '`');

        $sql = file_get_contents(ROOT_PATH . '/database/schema.sql');
        $sql = preg_replace('/CREATE DATABASE.*?;/s', '', $sql);
        $sql = preg_replace('/USE mobilehub;/', '', $sql);

        foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
            if ($statement !== '') {
                $pdo->exec($statement);
            }
        }

        Database::connection();

        self::seedUsers();
        self::seedCatalog();
        self::seedProducts();
        self::seedSettings();

        return ['ok' => true, 'message' => 'Database installed successfully!'];
    }

    private static function seedUsers(): void
    {
        $pdo = Database::connection();
        if ($pdo->query('SELECT COUNT(*) FROM users')->fetchColumn() > 0) {
            return;
        }

        $users = [
            ['Admin User', 'admin@mobilehub.bd', 'admin123', 'admin', '01711000001'],
            ['Moderator User', 'mod@mobilehub.bd', 'mod123', 'moderator', '01711000002'],
            ['Customer Demo', 'customer@mobilehub.bd', 'customer123', 'customer', '01711000003'],
        ];

        $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role, phone) VALUES (?,?,?,?,?)');
        foreach ($users as $u) {
            $stmt->execute([$u[0], $u[1], password_hash($u[2], PASSWORD_DEFAULT), $u[3], $u[4]]);
        }
    }

    private static function seedProducts(): void
    {
        $pdo = Database::connection();
        if ($pdo->query('SELECT COUNT(*) FROM products')->fetchColumn() > 0) {
            return;
        }

        $fileProducts = file_exists(ROOT_PATH . '/data/products.php')
            ? require ROOT_PATH . '/data/products.php'
            : [];

        $stmt = $pdo->prepare(
            'INSERT INTO products (id, name, brand, category, section, price, old_price, stock, image, label, out_of_stock)
             VALUES (?,?,?,?,?,?,?,?,?,?,?)'
        );

        foreach ($fileProducts as $p) {
            $stmt->execute([
                $p['id'], $p['name'], $p['brand'], $p['category'] ?? 'phones',
                $p['section'], $p['price'], $p['oldPrice'], 50,
                $p['image'], $p['label'], !empty($p['outOfStock']) ? 1 : 0,
            ]);
        }
    }

    private static function seedCatalog(): void
    {
        $pdo = Database::connection();

        // Categories
        if ((int) $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn() === 0) {
            $categories = [
                ['phones', 'Phones', '📱', 1],
                ['tablets', 'Tablets', '📲', 2],
                ['laptops', 'Laptops', '💻', 3],
                ['smartwatch', 'Smart Watch', '⌚', 4],
                ['gadgets', 'Gadgets', '🎧', 5],
                ['accessories', 'Accessories', '🔌', 6],
                ['sounds', 'Sounds', '🔊', 7],
                ['smarttv', 'Smart TV', '📺', 8],
            ];
            $stmt = $pdo->prepare('INSERT INTO categories (slug, name, icon, sort_order, is_active) VALUES (?,?,?,?,1)');
            foreach ($categories as $c) {
                $stmt->execute([$c[0], $c[1], $c[2], $c[3]]);
            }
        }

        // Brands
        if ((int) $pdo->query('SELECT COUNT(*) FROM brands')->fetchColumn() === 0) {
            $brands = [
                ['samsung', 'Samsung', 1],
                ['apple', 'Apple', 2],
                ['xiaomi', 'Xiaomi', 3],
                ['oppo', 'Oppo', 4],
                ['vivo', 'Vivo', 5],
                ['realme', 'Realme', 6],
                ['oneplus', 'OnePlus', 7],
                ['infinix', 'Infinix', 8],
                ['tecno', 'Tecno', 9],
                ['motorola', 'Motorola', 10],
                ['google', 'Google', 11],
                ['nothing', 'Nothing', 12],
            ];
            $stmt = $pdo->prepare('INSERT INTO brands (slug, name, sort_order, is_active) VALUES (?,?,?,1)');
            foreach ($brands as $b) {
                $stmt->execute([$b[0], $b[1], $b[2]]);
            }
        }
    }

    private static function seedSettings(): void
    {
        $pdo = Database::connection();
        $settings = [
            'site_name' => 'MobileHub BD',
            'site_phone' => '01712-345678',
            'site_email' => 'info@mobilehubbd.com',
            'free_delivery_min' => '5000',
        ];
        $stmt = $pdo->prepare('INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (?,?)');
        foreach ($settings as $k => $v) {
            $stmt->execute([$k, $v]);
        }
    }
}
