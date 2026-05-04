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
        // Get all pet owners
        $petOwners = DB::table('pet_owners')->get();

        foreach ($petOwners as $owner) {
            // Find the address belonging to this pet owner (morph relation)
            $address = DB::table('addresses')
                ->where('addressable_type', 'pet_owner')
                ->where('addressable_id', $owner->owner_id)
                ->first();

            if (! $address) {
                continue;
            }

            $updates = [];

            // Fill missing fields from pet_owner columns
            if (is_null($address->block_lot_phase) && ! empty($owner->blk_lot_ph)) {
                $updates['block_lot_phase'] = $owner->blk_lot_ph;
            }
            if (is_null($address->street) && ! empty($owner->street)) {
                $updates['street'] = $owner->street;
            }
            if (is_null($address->subdivision) && ! empty($owner->subdivision)) {
                $updates['subdivision'] = $owner->subdivision;
            }
            if (is_null($address->city) && ! empty($owner->city)) {
                $updates['city'] = $owner->city;
            }
            if (is_null($address->province) && ! empty($owner->province)) {
                $updates['province'] = $owner->province;
            }

            // Resolve barangay_id from barangay name if missing
            if (is_null($address->barangay_id) && ! empty($owner->barangay)) {
                $barangay = DB::table('barangays')
                    ->where('barangay_name', $owner->barangay)
                    ->first();
                if ($barangay) {
                    $updates['barangay_id'] = $barangay->barangay_id;
                }
            }

            if (! empty($updates)) {
                DB::table('addresses')
                    ->where('id', $address->id)
                    ->update($updates);
                echo "Updated address ID {$address->id} for owner {$owner->owner_id}\n";
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No schema changes; data fix is irreversible easily.
        // This does not revert the updates.
    }
};
