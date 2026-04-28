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
            $table->unsignedBigInteger('vaccination_report_id')->nullable()->after('id');
            $table->foreign('vaccination_report_id')
                ->references('id')
                ->on('vaccination_reports')
                ->onDelete('set null');
            $table->index('vaccination_report_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rabies_vaccination_reports', function (Blueprint $table) {
            $table->dropForeign(['vaccination_report_id']);
            $table->dropColumn('vaccination_report_id');
        });
    }
};
