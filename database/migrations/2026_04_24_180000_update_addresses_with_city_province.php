<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if backup table exists
        if (! Schema::hasTable('pet_owners_backup_20260424')) {
            return;
        }

        // Get all backup records with city/province data
        $backupRows = DB::table('pet_owners_backup_20260424')
            ->whereNotNull('city')
            ->orWhereNotNull('province')
            ->get();

        foreach ($backupRows as $row) {
            // Find the corresponding address record
            $address = DB::table('addresses')
                ->where('addressable_type', 'App\Models\PetOwner')
                ->where('addressable_id', $row->owner_id)
                ->first();

            if (! $address) {
                // Try with 'pet_owner' as addressable_type
                $address = DB::table('addresses')
                    ->where('addressable_type', 'pet_owner')
                    ->where('addressable_id', $row->owner_id)
                    ->first();
            }

            if ($address) {
                DB::table('addresses')
                    ->where('id', $address->id)
                    ->update([
                        'city' => $row->city,
                        'province' => $row->province,
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set city/province back to NULL for pet_owner addresses
        DB::table('addresses')
            ->where('addressable_type', 'App\Models\PetOwner')
            ->orWhere('addressable_type', 'pet_owner')
            ->update([
                'city' => null,
                'province' => null,
            ]);
    }
};
