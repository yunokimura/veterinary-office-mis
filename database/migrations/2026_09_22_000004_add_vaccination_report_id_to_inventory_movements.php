<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            if (!Schema::hasColumn('inventory_movements', 'vaccination_report_id')) {
                $table->unsignedBigInteger('vaccination_report_id')->nullable()->after('target_barangay_id');
                $table->foreign('vaccination_report_id')->references('id')->on('vaccination_reports')->onDelete('set null');
                $table->index('vaccination_report_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            if (Schema::hasColumn('inventory_movements', 'vaccination_report_id')) {
                $table->dropForeign(['vaccination_report_id']);
                $table->dropColumn('vaccination_report_id');
            }
        });
    }
};
