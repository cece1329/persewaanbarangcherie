<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

// Enable error reporting for serverless debugging
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Essential environment variable overrides for Vercel Serverless (Force SQLite & /tmp cache)
$envOverrides = [
    'APP_NAME' => 'ChérieRent',
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'true',
    'APP_KEY' => 'base64:rWZfocJKOgHefIZWMBVh6DzaKLR8rUPEjrjIEUMv3ww=',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => '/tmp/database.sqlite',
    'APP_SERVICES_CACHE' => '/tmp/bootstrap/cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/bootstrap/cache/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/bootstrap/cache/config.php',
    'APP_ROUTES_CACHE' => '/tmp/bootstrap/cache/routes-v7.php',
    'APP_EVENTS_CACHE' => '/tmp/bootstrap/cache/events.php',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'CACHE_STORE' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'LOG_CHANNEL' => 'stderr',
];

foreach ($envOverrides as $key => $val) {
    putenv("{$key}={$val}");
    $_ENV[$key] = $val;
    $_SERVER[$key] = $val;
}

// Auto-create writable storage & cache directories in /tmp for Vercel Serverless environment
$writableDirectories = [
    '/tmp/bootstrap/cache',
    '/tmp/storage/app/public',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($writableDirectories as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Auto-copy pre-seeded SQLite database to /tmp if using SQLite on Vercel
$repoSqlite = __DIR__.'/../database/database.sqlite';
$tmpSqlite = '/tmp/database.sqlite';

if (file_exists($repoSqlite)) {
    if (! file_exists($tmpSqlite) || filesize($tmpSqlite) === 0) {
        @copy($repoSqlite, $tmpSqlite);
    }
} else {
    if (! file_exists($tmpSqlite)) {
        @touch($tmpSqlite);
    }
}

// Forward Vercel incoming requests to Laravel front controller
try {
    require __DIR__.'/../vendor/autoload.php';

    /** @var Application $app */
    $app = require __DIR__.'/../bootstrap/app.php';

    // Explicitly redirect storage path to /tmp/storage
    $app->useStoragePath('/tmp/storage');

    // Auto-migrate and seed if SQLite database is empty / tables missing
    try {
        if (! Schema::hasTable('dresses')) {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
        }
    } catch (Throwable $dbEx) {
        // Silently continue if already initialized or migration error
    }

    $request = Request::capture();
    $app->handleRequest($request);

} catch (Throwable $e) {
    echo '<h2>Serverless Application Error</h2>';
    echo '<p><strong>Message:</strong> '.htmlspecialchars($e->getMessage()).'</p>';
    echo '<p><strong>File:</strong> '.htmlspecialchars($e->getFile()).' on line '.$e->getLine().'</p>';
    echo '<pre>'.htmlspecialchars($e->getTraceAsString()).'</pre>';
}
