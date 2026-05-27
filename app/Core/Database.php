<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $cfg = require ROOT_PATH . '/config/database.php';

        if ($cfg['driver'] === 'sqlite') {
            $path = ROOT_PATH . '/storage/database.sqlite';
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            self::$pdo = new PDO('sqlite:' . $path);
        } else {
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $cfg['host'],
                $cfg['port'],
                $cfg['database'],
                $cfg['charset']
            );
            self::$pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return self::$pdo;
    }

    public static function isReady(): bool
    {
        try {
            self::connection()->query('SELECT 1 FROM users LIMIT 1');
            return true;
        } catch (PDOException) {
            return false;
        }
    }
}
