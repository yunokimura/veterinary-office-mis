<?php

// Quick direct check for Chelsy's address linkage
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

    // Check Chelsy (owner_id=11) address via polymorphic
    echo "=== Addresses linked to pet_owner owner_id=11 ===\n";
    $stmt = $pdo->prepare("SELECT id, addressable_type, addressable_id, city, province, street FROM addresses WHERE addressable_type IN ('App\\\\Models\\\\PetOwner','pet_owner') AND addressable_id = 11");
    $stmt->execute();
    $addrs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($addrs as $a) {
        echo "Address ID: {$a['id']}, city: {$a['city']}, province: {$a['province']}, street: {$a['street']}\n";
    }

    echo "\n=== pet_owner record ===\n";
    $stmt = $pdo->prepare('SELECT owner_id, first_name, last_name, address_id FROM pet_owners WHERE owner_id = 11');
    $stmt->execute();
    $po = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Owner ID: {$po['owner_id']}, Name: {$po['first_name']} {$po['last_name']}, address_id: ".($po['address_id'] ?? 'NULL')."\n";

} catch (Exception $e) {
    echo 'ERROR: '.$e->getMessage()."\n";
}
