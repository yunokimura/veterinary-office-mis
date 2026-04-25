<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

echo "Updating addresses with city/province from pet_owners...\n";

// Get all pet_owner addresses
$addresses = DB::table('addresses')->where('addressable_type', 'pet_owner')->get();

$updated = 0;
foreach ($addresses as $addr) {
    // Get pet_owner
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
