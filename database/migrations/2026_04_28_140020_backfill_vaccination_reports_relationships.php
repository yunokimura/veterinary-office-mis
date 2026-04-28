<?php

use App\Models\Address;
use App\Models\Barangay;
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
        // Get all vaccination reports that need backfilling
        $reports = DB::table('vaccination_reports')->get();

        foreach ($reports as $report) {
            // Step 1: Backfill owner_id from user_id if null
            if (is_null($report->owner_id)) {
                $petOwner = PetOwner::where('user_id', $report->user_id)->first();
                if ($petOwner) {
                    DB::table('vaccination_reports')
                        ->where('id', $report->id)
                        ->update(['owner_id' => $petOwner->owner_id]);
                }
            }

            // Step 2: Create Address record and link it
            if (! empty($report->blk_lot_ph) || ! empty($report->street) || ! empty($report->barangay)) {
                // Resolve barangay_id
                $barangayId = null;
                if (! empty($report->barangay)) {
                    $barangay = Barangay::firstOrCreate(
                        ['barangay_name' => $report->barangay],
                        ['city' => 'Dasmariñas City', 'province' => 'Cavite', 'status' => 'active']
                    );
                    $barangayId = $barangay->barangay_id;
                }

                // Create the Address record
                $address = Address::create([
                    'block_lot_phase' => $report->blk_lot_ph,
                    'street' => $report->street,
                    'subdivision' => null,
                    'barangay_id' => $barangayId,
                    'city' => 'Dasmariñas City',
                    'province' => 'Cavite',
                    'postal_code' => null,
                    'is_primary' => true,
                ]);

                // Link address to vaccination report
                DB::table('vaccination_reports')
                    ->where('id', $report->id)
                    ->update(['address_id' => $address->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear owner_id and address_id (set to null)
        DB::table('vaccination_reports')->update([
            'owner_id' => null,
            'address_id' => null,
        ]);

        // Optionally, delete the Address records we created
        // This is safe because addresses are only linked from vaccination_reports
        // and were all created by this migration
        DB::table('addresses')->whereIn('id', function ($query) {
            $query->select('address_id')
                ->from('vaccination_reports')
                ->whereNotNull('address_id');
        })->delete();
    }
};
