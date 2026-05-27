<?php
namespace App\Core;

use App\Models\UserModel;

class Auth
{
    public static function user(): ?array
    {
        return Session::get('user');
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function id(): ?int
    {
        $user = self::user();
        return $user ? (int) $user['id'] : null;
    }

    public static function role(): ?string
    {
        return self::user()['role'] ?? null;
    }

    public static function login(array $user): void
    {
        unset($user['password']);
        Session::set('user', $user);
    }

    public static function logout(): void
    {
        Session::set('user', null);
    }

    public static function isAdmin(): bool
    {
        return self::role() === 'admin';
    }

    public static function isModerator(): bool
    {
        return self::role() === 'moderator';
    }

    public static function isCustomer(): bool
    {
        return self::role() === 'customer';
    }

    public static function isStaff(): bool
    {
        return in_array(self::role(), ['admin', 'moderator'], true);
    }

    public static function attempt(string $email, string $password): bool
    {
        $user = UserModel::findByEmail($email);
        if (!$user || $user['status'] === 'blocked') {
            return false;
        }
        if (!password_verify($password, $user['password'])) {
            return false;
        }
        self::login($user);
        return true;
    }
}
