<?php
namespace App\Middleware;

use App\Core\Auth;
use App\Core\Session;
use App\Core\Permission;
use App\Core\View;

class RoleMiddleware
{
    public static function handle(array $roles): bool
    {
        if (!Auth::check()) {
            Session::flash('error', 'Please login first.');
            header('Location: ' . url('/login'));
            exit;
        }

        if (!in_array(Auth::role(), $roles, true)) {
            http_response_code(403);
            View::render('errors/403', ['title' => 'Access Denied']);
            exit;
        }

        return true;
    }

    public static function guest(): bool
    {
        if (Auth::check()) {
            header('Location: ' . url(Permission::dashboardUrl()));
            exit;
        }
        return true;
    }
}
