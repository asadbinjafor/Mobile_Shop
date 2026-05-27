<?php
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function config(string $key, mixed $default = null): mixed
{
    return App\Core\App::config($key, $default);
}

function base_url(string $path = ''): string
{
    return App\Core\App::baseUrl($path);
}

function asset(string $path): string
{
    return base_url('/' . ltrim($path, '/'));
}

function url(string $path = ''): string
{
    return base_url($path);
}
