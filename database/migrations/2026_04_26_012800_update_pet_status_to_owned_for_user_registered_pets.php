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
        // Step 1: Add 'owned' to the pet_status ENUM
        DB::statement("ALTER TABLE pets MODIFY COLUMN pet_status ENUM('available', 'adopted', 'pending', 'unavailable', 'missing', 'owned') DEFAULT 'available' NOT NULL");

        // Step 2: Update pets that have an owner linked to a user
        DB::table('pets')
            ->whereIn('owner_id', function ($query) {
                $query->select('owner_id')
                    ->from('pet_owners')
                    ->whereNotNull('user_id');
            })
            ->update(['pet_status' => 'owned']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert ENUM back to original (without 'owned')
        // Note: Data changes from up() are not reversed
        DB::statement("ALTER TABLE pets MODIFY COLUMN pet_status ENUM('available', 'adopted', 'pending', 'unavailable', 'missing') DEFAULT 'available' NOT NULL");
    }
};
