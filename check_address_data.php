<?php

// Check pet owner address and barangay data
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PetOwner;

echo "=== Checking Pet Owner Address Data ===\n\n";

$owners = PetOwner::with(['address.barangay'])->get();

foreach ($owners as $owner) {
    $hasAddr = $owner->address ? 'yes' : 'no';
    $hasBrgy = ($owner->address && $owner->address->barangay) ? 'yes' : 'no';
    $brgyName = ($owner->address && $owner->address->barangay) ? $owner->address->barangay->barangay_name : 'N/A';
    $barangayId = $owner->address ? $owner->address->barangay_id : 'N/A';

    echo "Owner ID: {$owner->owner_id}, Name: {$owner->first_name} {$owner->last_name}\n";
    echo "  Address exists: $hasAddr\n";
    echo '  Address ID: '.($owner->address?->id ?? 'null')."\n";
    echo "  Barangay ID (in addresses): $barangayId\n";
    echo "  Barangay relation: $hasBrgy\n";
    echo "  Barangay name: $brgyName\n";
    echo "\n";
}

echo "\n=== Total owners: ".$owners->count()." ===\n";
