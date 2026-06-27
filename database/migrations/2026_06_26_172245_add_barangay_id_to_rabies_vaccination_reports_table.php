<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds barangay_id column to rabies_vaccination_reports table
     * This enables proper barangay tracking for vaccination reports
     */
    public function up(): void
    {
        Schema::table('rabies_vaccination_reports', function (Blueprint $table) {
            // Add barangay_id column as nullable to preserve existing data
            $table->unsignedBigInteger('barangay_id')->nullable()->after('patient_address');
            
            // Add foreign key constraint
            $table->foreign('barangay_id')
                  ->references('barangay_id')
                  ->on('barangays')
                  ->onDelete('set null');
            
            // Add index for better query performance
            $table->index('barangay_id');
        });
    }

    /**
     * Reverse the migrations.
     * Only removes the added column and constraints, preserves all other data
     */
    public function down(): void
    {
        Schema::table('rabies_vaccination_reports', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['barangay_id']);
            
            // Drop the index
            $table->dropIndex(['barangay_id']);
            
            // Drop the column
            $table->dropColumn('barangay_id');
        });
    }
};