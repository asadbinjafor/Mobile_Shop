<?php
declare(strict_types=1);

define('ROOT_PATH', __DIR__);

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $file = ROOT_PATH . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require ROOT_PATH . '/app/Helpers/functions.php';

$config = require ROOT_PATH . '/config/config.php';

App\Core\Session::start();
App\Core\App::init($config);
