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
        // Backfill address_id from the pet_owners table via owner_id
        // Using a direct join for efficiency
        DB::statement('
            UPDATE adoption_applications aa
            JOIN pet_owners po ON aa.owner_id = po.owner_id
            SET aa.address_id = po.address_id
            WHERE po.address_id IS NOT NULL
        ');

        // For any records where owner has no address_id, try to create an Address from denormalized fields
        // (This handles edge cases; in fresh empty DB it won't run)
        $records = DB::table('adoption_applications')
            ->whereNull('address_id')
            ->whereNotNull('blk_lot_ph')
            ->get();

        foreach ($records as $record) {
            // Try to find or create Barangay from barangay string
            $barangayId = null;
            if ($record->barangay) {
                $barangay = DB::table('barangays')
                    ->where('barangay_name', $record->barangay)
                    ->first();
                if (! $barangay) {
                    $barangayId = DB::table('barangays')->insertGetId([
                        'barangay_name' => $record->barangay,
                        'city' => 'Dasmariñas City',
                        'province' => 'Cavite',
                        'status' => 'active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $barangayId = $barangay->barangay_id;
                }
            }

            // Create Address record
            $addressId = DB::table('addresses')->insertGetId([
                'block_lot_phase' => $record->blk_lot_ph,
                'street' => $record->street,
                'subdivision' => null,
                'barangay_id' => $barangayId,
                'city' => 'Dasmariñas City',
                'province' => 'Cavite',
                'postal_code' => null,
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('adoption_applications')
                ->where('id', $record->id)
                ->update(['address_id' => $addressId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear address_id (set to null)
        DB::table('adoption_applications')->update(['address_id' => null]);
    }
};
