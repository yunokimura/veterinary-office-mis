<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'exposure_type')) {
                $table->dropColumn('exposure_type');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'category')) {
                $table->dropColumn('category');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->enum('exposure_type', ['bite', 'scratch', 'lick'])->nullable()->after('incident_date');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->enum('category', ['I', 'II', 'III'])->nullable()->after('exposure_type');
        });
    }
};
