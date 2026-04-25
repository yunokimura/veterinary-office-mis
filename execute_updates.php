<?php

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

echo "Updating addresses with city and province from pet_owners...\n";

// Get all pet_owner addresses
$addresses = DB::table('addresses')->where('addressable_type', 'pet_owner')->get();
$updated = 0;

foreach ($addresses as $addr) {
    $petOwner = DB::table('pet_owners')->where('owner_id', $addr->addressable_id)->first();

    if ($petOwner && ($petOwner->city || $petOwner->province)) {
        DB::table('addresses')->where('id', $addr->id)->update([
            'city' => $petOwner->city,
            'province' => $petOwner->province,
        ]);
        $updated++;
        echo "Updated address ID {$addr->id} with city: {$petOwner->city}, province: {$petOwner->province}\n";
    }
}

echo "\nDone! Updated {$updated} addresses.\n";

// Now drop deprecated columns from pet_owners (except barangay_id)
echo "\nDropping deprecated columns from pet_owners...\n";

$columnsToDrop = ['blk_lot_ph', 'street', 'subdivision', 'city', 'province', 'email'];

foreach ($columnsToDrop as $col) {
    $exists = DB::select("SHOW COLUMNS FROM pet_owners LIKE '{$col}'");
    if (! empty($exists)) {
        DB::statement("ALTER TABLE pet_owners DROP COLUMN {$col}");
        echo "Dropped {$col}\n";
    }
}

// Also drop barangay_id FK first
$exists = DB::select("SHOW COLUMNS FROM pet_owners LIKE 'barangay'");
if (! empty($exists)) {
    // Drop FK first
    try {
        DB::statement('ALTER TABLE pet_owners DROP FOREIGN KEY pet_owners_barangay_foreign');
    } catch (Exception $e) {
        // FK might have different name
    }
    DB::statement('ALTER TABLE pet_owners DROP COLUMN barangay');
    echo "Dropped barangay (with FK)\n";
}

echo "\n✅ All deprecated columns removed from pet_owners.\n";
echo "✅ Addresses table updated with city and province.\n";
