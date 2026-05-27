<?php
namespace App\Core;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        View::render($template, $data);
    }

    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect(string $path, ?string $flash = null): void
    {
        if ($flash) {
            Session::flash('success', $flash);
        }
        header('Location: ' . url($path));
        exit;
    }

    protected function requirePermission(string $permission): void
    {
        if (!Permission::can($permission)) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Permission Denied']);
            exit;
        }
    }
}
