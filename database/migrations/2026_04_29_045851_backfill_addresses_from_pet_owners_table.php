<?php

use App\Models\PetOwner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all pet owners without an address record via polymorphic relation
        $petOwners = PetOwner::doesntHave('address')->get();

        foreach ($petOwners as $owner) {
            // Resolve barangay_id from barangay name
            $barangayId = null;
            if (! empty($owner->barangay)) {
                $barangay = DB::table('barangays')
                    ->where('barangay_name', $owner->barangay)
                    ->first();
                if ($barangay) {
                    $barangayId = $barangay->barangay_id;
                }
            }

            DB::table('addresses')->insert([
                'addressable_type' => 'pet_owner',
                'addressable_id' => $owner->owner_id,
                'block_lot_phase' => $owner->blk_lot_ph,
                'street' => $owner->street,
                'subdivision' => $owner->subdivision,
                'barangay_id' => $barangayId,
                'city' => $owner->city,
                'province' => $owner->province,
                'postal_code' => null,
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete all addresses that belong to pet owners created by this migration
        DB::table('addresses')
            ->whereIn('addressable_type', ['App\Models\PetOwner', 'pet_owner'])
            ->delete();
    }
};
