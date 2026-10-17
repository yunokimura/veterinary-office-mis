<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pet_info', function (Blueprint $table) {
            $table->string('eye_color')->nullable()->after('allergy');
        });

        \DB::table('pet_info')->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('missing_pets_reports')
                ->whereColumn('missing_pets_reports.pet_id', 'pet_info.pet_id')
                ->whereNotNull('missing_pets_reports.eye_color')
                ->where('missing_pets_reports.eye_color', '!=', '')
                ->orderByDesc('missing_pets_reports.created_at')
                ->orderByDesc('missing_pets_reports.report_id')
                ->limit(1);
        })->update(['eye_color' => DB::raw('(
            SELECT mr.eye_color FROM missing_pets_reports mr
            WHERE mr.pet_id = pet_info.pet_id
              AND mr.eye_color IS NOT NULL
              AND mr.eye_color != ""
            ORDER BY mr.created_at DESC, mr.report_id DESC
            LIMIT 1
        )')]);

        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->dropColumn('eye_color');
        });
    }

    public function down(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->string('eye_color')->nullable()->after('body_marks');
        });

        Schema::table('pet_info', function (Blueprint $table) {
            $table->dropColumn('eye_color');
        });
    }
};
