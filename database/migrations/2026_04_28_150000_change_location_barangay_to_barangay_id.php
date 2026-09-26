<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id')->nullable()->after('last_seen_at');
        });

        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->dropColumn('location_barangay');
        });

        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
        });

        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->string('location_barangay')->nullable()->after('last_seen_at');
        });

        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->dropColumn('barangay_id');
        });
    }
};
