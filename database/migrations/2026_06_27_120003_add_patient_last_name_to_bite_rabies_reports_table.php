<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            // Add patient_last_name column after patient_first_name
            $table->string('patient_last_name')->nullable()->after('patient_first_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->dropColumn('patient_last_name');
        });
    }
};