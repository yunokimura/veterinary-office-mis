<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

echo "=== Verification of Address Fix ===\n\n";

// Count NULL address_id
$nullAddr = DB::table('pet_owners')->whereNull('address_id')->count();
echo "pet_owners with NULL address_id: $nullAddr\n";

// Count NULL city/province for pet_owner addresses
$nullCity = DB::table('addresses')
    ->whereIn('addressable_type', ['App\Models\PetOwner', 'pet_owner'])
    ->whereNull('city')
    ->count();
echo "pet_owner addresses with NULL city: $nullCity\n";

$nullProv = DB::table('addresses')
    ->whereIn('addressable_type', ['App\Models\PetOwner', 'pet_owner'])
    ->whereNull('province')
    ->count();
echo "pet_owner addresses with NULL province: $nullProv\n";

echo "\nRecent 3 pet_owner addresses:\n";
$rows = DB::table('pet_owners')
    ->join('addresses', 'pet_owners.address_id', '=', 'addresses.id')
    ->select('pet_owners.owner_id', 'pet_owners.first_name', 'pet_owners.last_name', 'addresses.city', 'addresses.province', 'addresses.street')
    ->orderBy('pet_owners.created_at', 'desc')
    ->limit(3)
    ->get();

foreach ($rows as $r) {
    echo sprintf("ID:%d %s %s | city:%-15s | province:%-10s | street:%s\n",
        $r->owner_id, $r->first_name, $r->last_name,
        $r->city ?? 'NULL',
        $r->province ?? 'NULL',
        $r->street ?? 'NULL'
    );
}
