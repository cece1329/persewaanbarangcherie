<?php

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

if (file_exists($repoSqlite) && !file_exists($tmpSqlite)) {
    @copy($repoSqlite, $tmpSqlite);
}

// Forward Vercel incoming requests to Laravel's front controller
require __DIR__ . '/../public/index.php';
