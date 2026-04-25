<?php

// Run this script: php update_addresses_city_province.php

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

echo "Starting to update addresses with city and province from pet_owners...\n";

// Get all addresses with their pet_owner data
$addresses = DB::table('addresses')
    ->where('addressable_type', 'pet_owner')
    ->get();

$updated = 0;
foreach ($addresses as $addr) {
    // Get the pet_owner
    $petOwner = DB::table('pet_owners')->where('owner_id', $addr->addressable_id)->first();

    if ($petOwner && ($petOwner->city || $petOwner->province)) {
        DB::table('addresses')
            ->where('id', $addr->id)
            ->update([
                'city' => $petOwner->city,
                'province' => $petOwner->province,
            ]);
        $updated++;
        echo "Updated address ID {$addr->id} with city: {$petOwner->city}, province: {$petOwner->province}\n";
    }
}

echo "\nDone! Updated {$updated} addresses.\n";

// Now drop columns from pet_owners
echo "\nDropping deprecated columns from pet_owners...\n";

// Check if columns exist first
$columns = DB::select("SHOW COLUMNS FROM pet_owners LIKE 'blk_lot_ph'");
if (! empty($columns)) {
    DB::statement('ALTER TABLE pet_owners DROP COLUMN blk_lot_ph');
    echo "Dropped blk_lot_ph\n";
}

$columns = DB::select("SHOW COLUMNS FROM pet_owners LIKE 'street'");
if (! empty($columns)) {
    DB::statement('ALTER TABLE pet_owners DROP COLUMN street');
    echo "Dropped street\n";
}

$columns = DB::select("SHOW COLUMNS FROM pet_owners LIKE 'subdivision'");
if (! empty($columns)) {
    DB::statement('ALTER TABLE pet_owners DROP COLUMN subdivision');
    echo "Dropped subdivision\n";
}

$columns = DB::select("SHOW COLUMNS FROM pet_owners LIKE 'barangay'");
if (! empty($columns)) {
    // Need to drop FK first
    DB::statement('ALTER TABLE pet_owners DROP FOREIGN KEY pet_owners_barangay_foreign');
    DB::statement('ALTER TABLE pet_owners DROP COLUMN barangay');
    echo "Dropped barangay (with FK)\n";
}

$columns = DB::select("SHOW COLUMNS FROM pet_owners LIKE 'city'");
if (! empty($columns)) {
    DB::statement('ALTER TABLE pet_owners DROP COLUMN city');
    echo "Dropped city\n";
}

$columns = DB::select("SHOW COLUMNS FROM pet_owners LIKE 'province'");
if (! empty($columns)) {
    DB::statement('ALTER TABLE pet_owners DROP COLUMN province');
    echo "Dropped province\n";
}

$columns = DB::select("SHOW COLUMNS FROM pet_owners LIKE 'email'");
if (! empty($columns)) {
    DB::statement('ALTER TABLE pet_owners DROP COLUMN email');
    echo "Dropped email\n";
}

echo "\n✅ All deprecated columns removed from pet_owners.\n";
echo "✅ Addresses table updated with city and province.\n";
