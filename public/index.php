<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Dynamic self-healing database setup for SQLite
$dbPath = __DIR__.'/../database/database.sqlite';
$needsSetup = true;
if (file_exists($dbPath)) {
    try {
        $db = new \PDO("sqlite:" . $dbPath);
        $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='pages'")->fetch();
        if ($result) {
            $needsSetup = false;
        }
    } catch (\Throwable $e) {
        // Setup will trigger
    }
}

if ($needsSetup) {
    try {
        if (!file_exists($dbPath)) {
            touch($dbPath);
        }
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        ob_start();
        $kernel->call('migrate', ['--force' => true]);
        $kernel->call('db:seed', ['--force' => true]);
        ob_end_clean();
    } catch (\Throwable $e) {
        error_log('Dynamic database initialization failed: ' . $e->getMessage());
    }
}

$app->handleRequest(Request::capture());

