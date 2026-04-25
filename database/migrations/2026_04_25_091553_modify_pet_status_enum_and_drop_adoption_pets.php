<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Ensure all pets have a valid pet_status
        // Set missing/empty pet_status to 'available' as default
        DB::table('pets')
            ->where(function ($query) {
                $query->whereNull('pet_status')->orWhere('pet_status', '');
            })
            ->update(['pet_status' => 'available']);

        // Step 2: Convert pet_status column to ENUM type
        try {
            DB::statement("ALTER TABLE pets MODIFY COLUMN pet_status ENUM('available', 'adopted', 'pending', 'unavailable', 'missing') DEFAULT 'available' NOT NULL");
        } catch (Exception $e) {
            Log::error('Failed to convert pet_status to enum: '.$e->getMessage());
            // Rethrow to fail migration
            throw $e;
        }

        // Step 3: Drop adoption_pets table if it still exists (should already be gone)
        if (Schema::hasTable('adoption_pets')) {
            // First try to drop any foreign keys that might reference adoption_pets
            try {
                DB::statement('ALTER TABLE pet_traits DROP FOREIGN KEY pet_traits_adoption_pet_id_foreign');
            } catch (Exception $e) {
                // Constraint may not exist
            }
            try {
                DB::statement('ALTER TABLE adoption_selected_pets DROP FOREIGN KEY adoption_selected_pets_adoption_pet_id_foreign');
            } catch (Exception $e) {
                // Constraint may not exist
            }
            // Drop the table
            Schema::drop('adoption_pets');
        }

        // Step 4: Clean up orphaned adoption_pet_id column from pet_traits
        if (Schema::hasTable('pet_traits') && Schema::hasColumn('pet_traits', 'adoption_pet_id')) {
            Schema::table('pet_traits', function (Blueprint $table) {
                $table->dropColumn('adoption_pet_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert enum to string (nullable)
        DB::statement('ALTER TABLE pets MODIFY COLUMN pet_status VARCHAR(50) NULL');

        // Note: Cannot fully restore adoption_pets table or adoption_pet_id column
        // Down migration is limited to enum reversion; data structure changes are irreversible
    }
};
