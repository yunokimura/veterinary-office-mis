<?php

// Parse .env to get DB credentials
$envPath = __DIR__.'/.env';
$env = file_get_contents($envPath);
$lines = explode("\n", $env);

$db = [
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'vet_system',
    'username' => 'root',
    'password' => '',
];

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '' || strpos($line, '#') === 0) {
        continue;
    }
    $parts = explode('=', $line, 2);
    if (count($parts) !== 2) {
        continue;
    }
    [$key, $value] = $parts;
    $value = trim($value);
    switch ($key) {
        case 'DB_HOST': $db['host'] = $value;
            break;
        case 'DB_PORT': $db['port'] = $value;
            break;
        case 'DB_DATABASE': $db['database'] = $value;
            break;
        case 'DB_USERNAME': $db['username'] = $value;
            break;
        case 'DB_PASSWORD': $db['password'] = $value;
            break;
    }
}

try {
    $dsn = "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $db['username'], $db['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    echo "=== Pet Owner with NULL address_id ===\n";
    $stmt = $pdo->query('SELECT owner_id, first_name, last_name, user_id FROM pet_owners WHERE address_id IS NULL');
    $nulls = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($nulls as $row) {
        echo "ID: {$row['owner_id']}, Name: {$row['first_name']} {$row['last_name']}, user_id: {$row['user_id']}\n";
    }

    echo "\n=== Pet Owner addresses city/province status ===\n";
    $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM addresses WHERE addressable_type IN ('App\\\\Models\\\\PetOwner','pet_owner') AND city IS NULL");
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "NULL city: {$r['cnt']}\n";

    $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM addresses WHERE addressable_type IN ('App\\\\Models\\\\PetOwner','pet_owner') AND province IS NULL");
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "NULL province: {$r['cnt']}\n";

    echo "\n=== Sample records (most recent 3) ===\n";
    $stmt = $pdo->query('
        SELECT p.owner_id, p.first_name, p.last_name, a.city, a.province, a.street
        FROM pet_owners p
        INNER JOIN addresses a ON p.address_id = a.id
        ORDER BY p.created_at DESC LIMIT 3
    ');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        echo sprintf("ID:%d %s %s | city:%-15s | province:%-10s | street:%s\n",
            $r['owner_id'], $r['first_name'], $r['last_name'],
            $r['city'] ?? 'NULL',
            $r['province'] ?? 'NULL',
            $r['street'] ?? 'NULL'
        );
    }

} catch (Exception $e) {
    echo 'ERROR: '.$e->getMessage()."\n";
}
