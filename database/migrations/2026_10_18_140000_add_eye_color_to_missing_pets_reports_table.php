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
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->string('eye_color')->nullable()->after('eye_color_other');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->dropColumn('eye_color');
        });
    }
};
