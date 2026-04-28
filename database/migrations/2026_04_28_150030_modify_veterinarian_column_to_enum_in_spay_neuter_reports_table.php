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
        // Clear existing veterinarian values (set to NULL)
        DB::table('spay_neuter_reports')
            ->whereNotIn('veterinarian', ['City Veterinarian', 'Assistant Veterinarian'])
            ->update(['veterinarian' => null]);

        // Modify column to ENUM
        DB::statement("
            ALTER TABLE spay_neuter_reports 
            MODIFY COLUMN veterinarian ENUM('City Veterinarian', 'Assistant Veterinarian') NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to string (no precision needed for the ENUM values)
        DB::statement('
            ALTER TABLE spay_neuter_reports 
            MODIFY COLUMN veterinarian VARCHAR(255) NULL
        ');
    }
};
