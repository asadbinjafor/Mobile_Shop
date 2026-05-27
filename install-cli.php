<?php
require __DIR__ . '/bootstrap.php';
try {
    $r = App\Core\Installer::run();
    echo $r['message'] . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
