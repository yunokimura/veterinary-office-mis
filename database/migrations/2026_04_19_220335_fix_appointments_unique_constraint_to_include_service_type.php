<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the existing unique constraint (without service_type)
        DB::statement('DROP INDEX IF EXISTS unique_date_time_slot ON appointments');

        // Add new unique constraint (including service_type)
        Schema::table('appointments', function (Blueprint $table) {
            $table->unique(['appointment_date', 'appointment_time', 'service_type'], 'unique_date_time_service_slot');
        });
    }

    public function down(): void
    {
        // Drop the new unique constraint
        DB::statement('DROP INDEX IF EXISTS unique_date_time_service_slot ON appointments');

        // Restore the original unique constraint
        Schema::table('appointments', function (Blueprint $table) {
            $table->unique(['appointment_date', 'appointment_time'], 'unique_date_time_slot');
        });
    }
};
