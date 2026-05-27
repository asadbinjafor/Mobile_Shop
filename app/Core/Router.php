<?php
namespace App\Core;

use App\Middleware\RoleMiddleware;

class Router
{
    private array $routes = [];

    public function get(string $pattern, array $handler, array $middleware = []): self
    {
        $this->routes[] = ['GET', $pattern, $handler, $middleware];
        return $this;
    }

    public function post(string $pattern, array $handler, array $middleware = []): self
    {
        $this->routes[] = ['POST', $pattern, $handler, $middleware];
        return $this;
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        $base = App::baseUrl();
        if ($base !== '' && strpos($path, $base) === 0) {
            $path = substr($path, strlen($base)) ?: '/';
        }
        $path = '/' . trim($path, '/');
        if ($path !== '/') {
            $path = rtrim($path, '/') ?: '/';
        }

        foreach ($this->routes as [$routeMethod, $pattern, $handler, $middleware]) {
            if ($routeMethod !== $method) {
                continue;
            }
            $regex = '#^' . preg_replace('#\{([a-zA-Z_]+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
            if (preg_match($regex, $path, $matches)) {
                $this->runMiddleware($middleware);
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                [$class, $action] = $handler;
                $controller = new $class();
                $controller->$action(...array_values($params));
                return;
            }
        }

        http_response_code(404);
        View::render('errors/404', ['title' => 'Page Not Found']);
    }

    private function runMiddleware(array $middleware): void
    {
        foreach ($middleware as $mw) {
            if ($mw === 'auth') {
                if (!Auth::check()) {
                    Session::flash('error', 'Login required.');
                    header('Location: ' . url('/login'));
                    exit;
                }
            } elseif (str_starts_with($mw, 'role:')) {
                $roles = explode(',', substr($mw, 5));
                RoleMiddleware::handle($roles);
            } elseif ($mw === 'guest') {
                RoleMiddleware::guest();
            }
        }
    }
}
