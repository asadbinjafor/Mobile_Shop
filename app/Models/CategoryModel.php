<?php
namespace App\Models;

use App\Core\Database;

class CategoryModel
{
    public static function all(): array
    {
        return Database::connection()
            ->query('SELECT * FROM categories ORDER BY sort_order ASC, id DESC')
            ->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM categories WHERE slug = ?');
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO categories (slug, name, icon, is_active, sort_order) VALUES (?,?,?,?,?)'
        );
        $stmt->execute([
            $data['slug'],
            $data['name'],
            $data['icon'] ?? null,
            !empty($data['is_active']) ? 1 : 0,
            (int) ($data['sort_order'] ?? 0),
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        Database::connection()->prepare(
            'UPDATE categories SET slug=?, name=?, icon=?, is_active=?, sort_order=? WHERE id=?'
        )->execute([
            $data['slug'],
            $data['name'],
            $data['icon'] ?? null,
            !empty($data['is_active']) ? 1 : 0,
            (int) ($data['sort_order'] ?? 0),
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        Database::connection()->prepare('DELETE FROM categories WHERE id = ?')->execute([$id]);
    }
}

