<?php
namespace App\Models;

use App\Core\Database;

class BrandModel
{
    public static function all(): array
    {
        return Database::connection()
            ->query('SELECT * FROM brands ORDER BY sort_order ASC, id DESC')
            ->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM brands WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM brands WHERE slug = ?');
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function findPublicBySlug(string $slug): ?array
    {
        try {
            $stmt = Database::connection()->prepare(
                'SELECT slug, name FROM brands WHERE slug = ? AND is_active = 1'
            );
            $stmt->execute([$slug]);
            $row = $stmt->fetch();
            if ($row) {
                return ['slug' => $row['slug'], 'name' => $row['name']];
            }
        } catch (\Throwable) {
            // fall through
        }
        return null;
    }

    public static function create(array $data): int
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO brands (slug, name, is_active, sort_order) VALUES (?,?,?,?)'
        );
        $stmt->execute([
            $data['slug'],
            $data['name'],
            !empty($data['is_active']) ? 1 : 0,
            (int) ($data['sort_order'] ?? 0),
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        Database::connection()->prepare(
            'UPDATE brands SET slug=?, name=?, is_active=?, sort_order=? WHERE id=?'
        )->execute([
            $data['slug'],
            $data['name'],
            !empty($data['is_active']) ? 1 : 0,
            (int) ($data['sort_order'] ?? 0),
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        Database::connection()->prepare('DELETE FROM brands WHERE id = ?')->execute([$id]);
    }
}

