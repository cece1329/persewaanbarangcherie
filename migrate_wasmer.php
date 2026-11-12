<?php
/**
 * Direct migration + seeding to Wasmer MySQL.
 * Uses PDO directly to avoid artisan drop issues with remote connections.
 */

$host = 'db.fr-roub1.bengt.wasmernet.com';
$port = '20184';
$dbname = 'rentcherie';
$user = 'user_555f251b';
$pass = 'pw_daeF4W7lgmtdM9jaNqeIHHOgYebHLZIA';

echo "Connecting to Wasmer MySQL...\n";
$pdo = new PDO(
    "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
    $user, $pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 30]
);
echo "Connected!\n\n";

// Disable FK checks for clean drop
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

// Drop existing tables
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
echo "Dropping " . count($tables) . " tables...\n";
foreach ($tables as $table) {
    $pdo->exec("DROP TABLE IF EXISTS `$table`");
    echo "  Dropped: $table\n";
}

$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
echo "\nAll tables dropped.\n\n";

// Now patch .env and run artisan migrate:fresh --seed WITHOUT --drop (tables already gone)
$envFile = __DIR__ . '/.env';
$original = file_get_contents($envFile);
$patched = preg_replace('/^DB_CONNECTION=.*/m', 'DB_CONNECTION=mysql', $original);
$patched = preg_replace('/^DB_HOST=.*/m', "DB_HOST=$host", $patched);
$patched = preg_replace('/^DB_PORT=.*/m', "DB_PORT=$port", $patched);
$patched = preg_replace('/^DB_DATABASE=.*/m', "DB_DATABASE=$dbname", $patched);
$patched = preg_replace('/^DB_USERNAME=.*/m', "DB_USERNAME=$user", $patched);
$patched = preg_replace('/^DB_PASSWORD=.*/m', "DB_PASSWORD=$pass", $patched);

file_put_contents($envFile, $patched);
echo "Patched .env...\n";

$php = 'C:\\laragon\\bin\\php\\php-8.3.16-Win32-vs16-x64\\php.exe';
$artisan = __DIR__ . '\\artisan';

// Clear config cache
passthru("\"$php\" \"$artisan\" config:clear 2>&1");

// Run migrate (not fresh, tables already dropped) + seed
echo "\nRunning migrate --seed...\n";
passthru("\"$php\" \"$artisan\" migrate --seed --no-interaction --force 2>&1");

// Restore .env
file_put_contents($envFile, $original);
passthru("\"$php\" \"$artisan\" config:clear 2>&1");
echo "\nRestored .env to local MySQL.\n";

// Verify admin user
$stmt = $pdo->query("SELECT id, name, email, role FROM users WHERE role='admin'");
echo "\nAdmin users in Wasmer MySQL:\n";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "  [{$row['id']}] {$row['name']} | {$row['email']} | {$row['role']}\n";
}

echo "\nDone!\n";
