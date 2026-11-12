<?php
try {
    $pdo = new PDO(
        'mysql:host=db.fr-roub1.bengt.wasmernet.com;port=20184;dbname=rentcherie',
        'user_555f251b',
        'pw_daeF4W7lgmtdM9jaNqeIHHOgYebHLZIA',
        [PDO::ATTR_TIMEOUT => 10, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo 'Connected! MySQL version: ' . $pdo->query('SELECT VERSION()')->fetchColumn() . PHP_EOL;
} catch (Exception $e) {
    echo 'Connection failed: ' . $e->getMessage() . PHP_EOL;
}

