<?php

// Load .env manually
$lines = file(__DIR__.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$env = [];
foreach ($lines as $line) {
    if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
}
$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$dbname = $env['DB_DATABASE'] ?? 'laravel';
$username = $env['DB_USERNAME'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ]);
    echo "Connected.\n";

    // Check pet_owner with owner_id=1
    $stmt = $pdo->prepare('SELECT * FROM pet_owners WHERE owner_id = ?');
    $stmt->execute([1]);
    $owner = $stmt->fetch();
    if ($owner) {
        echo "Owner 1 fields:\n";
        foreach (['blk_lot_ph', 'street', 'subdivision', 'barangay', 'city', 'province'] as $col) {
            echo "  $col: ".var_export($owner->$col ?? null, true)."\n";
        }
    } else {
        echo "No owner with ID 1\n";
    }

    // Also check addresses for owner 1
    $stmt2 = $pdo->prepare('SELECT * FROM addresses WHERE addressable_type = ? AND addressable_id = ?');
    $stmt2->execute(['pet_owner', 1]);
    $addr = $stmt2->fetch();
    if ($addr) {
        echo "\nAddress for owner 1:\n";
        foreach (['block_lot_phase', 'street', 'subdivision', 'barangay_id', 'city', 'province'] as $col) {
            echo "  $col: ".var_export($addr->$col ?? null, true)."\n";
        }
    } else {
        echo "\nNo address for owner 1\n";
    }

} catch (Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
}
