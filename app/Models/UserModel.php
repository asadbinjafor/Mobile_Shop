<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class UserModel
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function all(?string $role = null): array
    {
        if ($role) {
            $stmt = Database::connection()->prepare('SELECT id, name, email, role, status, phone, created_at FROM users WHERE role = ? ORDER BY id DESC');
            $stmt->execute([$role]);
        } else {
            $stmt = Database::connection()->query('SELECT id, name, email, role, status, phone, created_at FROM users ORDER BY id DESC');
        }
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO users (name, email, password, role, status, phone) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'] ?? 'customer',
            $data['status'] ?? 'active',
            $data['phone'] ?? null,
        ]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $fields = [];
        $values = [];
        foreach (['name', 'email', 'role', 'status', 'phone'] as $f) {
            if (array_key_exists($f, $data)) {
                $fields[] = "$f = ?";
                $values[] = $data[$f];
            }
        }
        if (isset($data['password']) && $data['password'] !== '') {
            $fields[] = 'password = ?';
            $values[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if (!$fields) {
            return;
        }
        $values[] = $id;
        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?';
        Database::connection()->prepare($sql)->execute($values);
    }

    public static function delete(int $id): void
    {
        Database::connection()->prepare('DELETE FROM users WHERE id = ? AND role != ?')->execute([$id, 'admin']);
    }

    public static function countByRole(): array
    {
        $rows = Database::connection()->query(
            'SELECT role, COUNT(*) as cnt FROM users GROUP BY role'
        )->fetchAll();
        $out = ['admin' => 0, 'moderator' => 0, 'customer' => 0];
        foreach ($rows as $r) {
            $out[$r['role']] = (int) $r['cnt'];
        }
        return $out;
    }
}
