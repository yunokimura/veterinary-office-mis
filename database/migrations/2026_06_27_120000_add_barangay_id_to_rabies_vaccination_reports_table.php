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
        Schema::table('rabies_vaccination_reports', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('rabies_vaccination_reports', 'barangay_id')) {
                $table->unsignedBigInteger('barangay_id')->nullable()->after('patient_address');
                $table->foreign('barangay_id')
                      ->references('barangay_id')
                      ->on('barangays')
                      ->onDelete('set null');
                $table->index('barangay_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rabies_vaccination_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_vaccination_reports', 'barangay_id')) {
                $table->dropForeign(['barangay_id']);
                $table->dropIndex(['barangay_id']);
                $table->dropColumn('barangay_id');
            }
        });
    }
};