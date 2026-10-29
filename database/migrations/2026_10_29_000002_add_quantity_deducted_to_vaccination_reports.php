<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add quantity_deducted column to vaccination_reports to explicitly record
     * how many inventory units were consumed per completed vaccination report.
     */
    public function up(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('vaccination_reports', 'quantity_deducted')) {
                $table->integer('quantity_deducted')->default(1)->nullable()->after('inventory_control_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            if (Schema::hasColumn('vaccination_reports', 'quantity_deducted')) {
                $table->dropColumn('quantity_deducted');
            }
        });
    }
};
