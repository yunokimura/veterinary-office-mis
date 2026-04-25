<?php

$host = '127.0.0.1';
$port = 3306;
$dbname = 'vet_system';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database.\n";

    // Get all pet_owner addresses
    $stmt = $pdo->query("
        SELECT a.id, a.addressable_id, po.city, po.province 
        FROM addresses a 
        JOIN pet_owners po ON a.addressable_id = po.owner_id 
        WHERE a.addressable_type = 'pet_owner'
    ");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $updated = 0;
    foreach ($rows as $row) {
        if ($row['city'] || $row['province']) {
            $sql = 'UPDATE addresses SET city = '.$pdo->quote($row['city']).', province = '.$pdo->quote($row['province']).' WHERE id = '.(int) $row['id'];
            $pdo->exec($sql);
            $updated++;
            echo "Updated address {$row['id']} with city: {$row['city']}, province: {$row['province']}\n";
        }
    }

    echo "\nDone! Updated $updated addresses.\n";

    // Now drop deprecated columns from pet_owners
    echo "\nDropping deprecated columns from pet_owners...\n";

    $columnsToDrop = ['blk_lot_ph', 'street', 'subdivision', 'barangay', 'city', 'province', 'email'];
    foreach ($columnsToDrop as $col) {
        // Check if column exists
        $check = $pdo->query("SHOW COLUMNS FROM pet_owners LIKE '$col'");
        $exists = $check->fetch();
        if ($exists) {
            // Drop FK first if barangay
            if ($col == 'barangay') {
                try {
                    $pdo->exec('ALTER TABLE pet_owners DROP FOREIGN KEY pet_owners_barangay_foreign');
                } catch (Exception $e) {
                    // FK might have different name
                }
            }
            $pdo->exec("ALTER TABLE pet_owners DROP COLUMN $col");
            echo "Dropped $col\n";
        }
    }

    echo "\n✅ All deprecated columns removed from pet_owners.\n";
    echo "✅ Addresses table updated with city and province.\n";

} catch (Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
}
