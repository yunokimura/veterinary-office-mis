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
        // Backfill city and province for existing pet_owner addresses
        // by deriving from the linked barangay data

        // Handle both possible addressable_type values for backward compatibility
        $addressableTypes = ['App\Models\PetOwner', 'pet_owner'];

        foreach ($addressableTypes as $addressableType) {
            $updated = DB::table('addresses')
                ->join('pet_owners', 'addresses.addressable_id', '=', 'pet_owners.owner_id')
                ->join('barangays', 'addresses.barangay_id', '=', 'barangays.barangay_id')
                ->where('addresses.addressable_type', $addressableType)
                ->whereNull('addresses.city')
                ->whereNull('addresses.province')
                ->select('addresses.id', 'barangays.city as barangay_city', 'barangays.province as barangay_province')
                ->get();

            foreach ($updated as $record) {
                DB::table('addresses')
                    ->where('id', $record->id)
                    ->update([
                        'city' => $record->barangay_city.' City',
                        'province' => $record->barangay_province,
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set city/province back to NULL for all pet_owner addresses
        DB::table('addresses')
            ->where('addressable_type', 'App\Models\PetOwner')
            ->orWhere('addressable_type', 'pet_owner')
            ->whereNotNull('city')
            ->whereNotNull('province')
            ->update([
                'city' => null,
                'province' => null,
            ]);
    }
};
