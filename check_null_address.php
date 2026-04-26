<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

$pet = DB::table('pet_owners')->whereNull('address_id')->first();
if ($pet) {
    echo "Pet Owner with NULL address_id:\n";
    echo "owner_id: {$pet->owner_id}\n";
    echo "first_name: {$pet->first_name}\n";
    echo "last_name: {$pet->last_name}\n";
    echo "user_id: {$pet->user_id}\n";

    // Check if they have an address via polymorphic
    $addr = DB::table('addresses')
        ->where('addressable_type', 'App\Models\PetOwner')
        ->where('addressable_id', $pet->owner_id)
        ->first();
    if ($addr) {
        echo "Has address via polymorphic (addressable) but address_id not set in pet_owners.\n";
        echo "Address ID: {$addr->id}, city: ".($addr->city ?? 'NULL').', province: '.($addr->province ?? 'NULL')."\n";
    } else {
        echo "No address record found at all.\n";
    }
} else {
    echo "No pet_owners with NULL address_id found.\n";
}
