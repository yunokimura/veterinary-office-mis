<?php

use Illuminate\Support\Facades\DB;

// Test that the fix works correctly
echo "=== Verification of Chelsy Joy's Registration Fix ===\n\n";

// Check recent pet_owner + address records
$petOwners = DB::table('pet_owners')
    ->join('addresses', 'pet_owners.address_id', '=', 'addresses.id')
    ->select('pet_owners.owner_id', 'pet_owners.first_name', 'pet_owners.last_name',
        'pet_owners.address_id', 'addresses.city', 'addresses.province', 'addresses.street')
    ->orderBy('pet_owners.created_at', 'desc')
    ->limit(5)
    ->get();

echo "Recent pet_owner records with address data:\n";
foreach ($petOwners as $po) {
    echo sprintf(
        "ID: %d | Name: %s %s | address_id: %s | city: %-20s | province: %-10s | street: %s\n",
        $po->owner_id,
        $po->first_name,
        $po->last_name,
        $po->address_id ?? 'NULL',
        $po->city ?? 'NULL',
        $po->province ?? 'NULL',
        $po->street ?? 'NULL'
    );
}

echo "\n\n";

// Check for any remaining NULLs
$nullAddressId = DB::table('pet_owners')->whereNull('address_id')->count();
$nullCity = DB::table('addresses')
    ->where('addressable_type', 'App\Models\PetOwner')
    ->orWhere('addressable_type', 'pet_owner')
    ->whereNull('city')
    ->count();
$nullProvince = DB::table('addresses')
    ->where('addressable_type', 'App\Models\PetOwner')
    ->orWhere('addressable_type', 'pet_owner')
    ->whereNull('province')
    ->count();

echo "Remaining NULL counts:\n";
echo "  pet_owners.address_id NULL: $nullAddressId\n";
echo "  addresses.city NULL (pet_owners): $nullCity\n";
echo "  addresses.province NULL (pet_owners): $nullProvince\n";

echo "\n=== Expected: All counts should be 0 after fix ===\n";
