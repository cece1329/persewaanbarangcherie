<?php

// Ensure essential Laravel environment variables fall back cleanly on Vercel
$envDefaults = [
    'APP_NAME' => 'ChérieRent',
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
    'APP_KEY' => 'base64:rWZfocJKOgHefIZWMBVh6DzaKLR8rUPEjrjIEUMv3ww=',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => '/tmp/database.sqlite',
    'CACHE_STORE' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'LOG_CHANNEL' => 'stderr',
];

foreach ($envDefaults as $key => $val) {
    if (empty(getenv($key)) && empty($_ENV[$key]) && empty($_SERVER[$key])) {
        putenv("{$key}={$val}");
        $_ENV[$key] = $val;
        $_SERVER[$key] = $val;
    }
}

// Auto-create writable storage directories in /tmp for Vercel Serverless environment
$storageDirectories = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirectories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Auto-copy pre-seeded SQLite database to /tmp if using SQLite on Vercel
$repoSqlite = __DIR__ . '/../database/database.sqlite';
$tmpSqlite = '/tmp/database.sqlite';

if (file_exists($repoSqlite) && (!file_exists($tmpSqlite) || filesize($tmpSqlite) === 0)) {
    @copy($repoSqlite, $tmpSqlite);
}

// Forward Vercel incoming requests to Laravel's front controller
require __DIR__ . '/../public/index.php';
