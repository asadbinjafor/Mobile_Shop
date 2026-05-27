<?php
namespace App\Core;

class App
{
    private static array $config = [];
    private static string $baseUrl = '';

    public static function init(array $config): void
    {
        self::$config = $config;
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        self::$baseUrl = rtrim($scriptDir, '/') ?: '';
    }

    public static function config(string $key, mixed $default = null): mixed
    {
        return self::$config[$key] ?? $default;
    }

    public static function baseUrl(string $path = ''): string
    {
        $path = $path === '' ? '' : '/' . ltrim($path, '/');
        return self::$baseUrl . $path;
    }

    public static function allConfig(): array
    {
        return self::$config;
    }
}
