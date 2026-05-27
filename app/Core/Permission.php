<?php
namespace App\Core;

class Permission
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_CUSTOMER = 'customer';

    private static array $matrix = [
        'admin' => [
            'users.*', 'products.*', 'orders.*', 'analytics.*',
            'settings.*', 'banners.*', 'coupons.*', 'reviews.*',
        ],
        'moderator' => [
            'products.view', 'products.create', 'products.update', 'products.stock',
            'orders.view', 'orders.update_status',
            'reviews.reply', 'reviews.moderate',
            'banners.update', 'offers.manage',
        ],
        'customer' => [
            'shop.browse', 'cart.use', 'checkout',
            'profile.edit', 'orders.own', 'orders.cancel_own',
            'reviews.create', 'wishlist.manage',
        ],
    ];

    public static function can(string $permission): bool
    {
        $role = Auth::role();
        if (!$role) {
            return false;
        }

        if ($role === self::ROLE_ADMIN) {
            return true;
        }

        $perms = self::$matrix[$role] ?? [];
        foreach ($perms as $p) {
            if ($p === $permission) {
                return true;
            }
            if (str_ends_with($p, '.*')) {
                $prefix = substr($p, 0, -2);
                if (str_starts_with($permission, $prefix)) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function roleLabel(string $role): string
    {
        return match ($role) {
            'admin' => 'Administrator',
            'moderator' => 'Moderator',
            'customer' => 'Customer',
            default => ucfirst($role),
        };
    }

    public static function dashboardUrl(): string
    {
        return match (Auth::role()) {
            'admin' => '/admin',
            'moderator' => '/moderator',
            default => '/account',
        };
    }
}
