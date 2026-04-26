<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Find all pet_owners with NULL address_id that have an address record
        // via the polymorphic relationship, and set address_id to that address's ID.
        $petOwners = DB::table('pet_owners')
            ->whereNull('address_id')
            ->get();

        foreach ($petOwners as $petOwner) {
            $address = DB::table('addresses')
                ->whereIn('addressable_type', ['App\Models\PetOwner', 'pet_owner'])
                ->where('addressable_id', $petOwner->owner_id)
                ->first();

            if ($address) {
                DB::table('pet_owners')
                    ->where('owner_id', $petOwner->owner_id)
                    ->update(['address_id' => $address->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set address_id back to NULL for pet_owners that have an address
        // linked via polymorphic relationship (i.e., those we updated)
        DB::table('pet_owners')
            ->whereNotNull('address_id')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('addresses')
                    ->whereColumn('addresses.addressable_id', 'pet_owners.owner_id')
                    ->whereIn('addresses.addressable_type', ['App\Models\PetOwner', 'pet_owner']);
            })
            ->update(['address_id' => null]);
    }
};
