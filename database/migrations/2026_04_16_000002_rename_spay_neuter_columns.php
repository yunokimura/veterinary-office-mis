<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add new columns
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->string('gender', 20)->nullable();
            $table->string('species', 50)->nullable();
            $table->dateTime('scheduled_at')->nullable();
        });

        // Step 2: Copy data from old columns to new columns
        DB::statement('UPDATE spay_neuter_reports SET gender = pet_sex WHERE pet_sex IS NOT NULL');
        DB::statement('UPDATE spay_neuter_reports SET species = pet_type WHERE pet_type IS NOT NULL');
        
        // Combine procedure_date with appointment_time from remarks to create scheduled_at
        DB::statement("
            UPDATE spay_neuter_reports 
            SET scheduled_at = CONCAT(procedure_date, ' ', COALESCE(JSON_UNQUOTE(JSON_EXTRACT(remarks, '$.appointment_time')), '09:00:00'))
            WHERE procedure_date IS NOT NULL
        ");

        // Step 3: Drop old columns
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->dropColumn('pet_sex');
            $table->dropColumn('pet_type');
            $table->dropColumn('procedure_date');
        });
    }

    public function down(): void
    {
        // Add back old columns
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->string('pet_sex', 20)->nullable();
            $table->string('pet_type', 50)->nullable();
            $table->date('procedure_date')->nullable();
        });

        // Copy data back to old columns
        DB::statement('UPDATE spay_neuter_reports SET pet_sex = gender WHERE gender IS NOT NULL');
        DB::statement('UPDATE spay_neuter_reports SET pet_type = species WHERE species IS NOT NULL');
        DB::statement('UPDATE spay_neuter_reports SET procedure_date = DATE(scheduled_at) WHERE scheduled_at IS NOT NULL');

        // Drop new columns
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('species');
            $table->dropColumn('scheduled_at');
        });
    }
};