<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->dropColumn('pet_color');
        });
    }

    public function down(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('pet_color')->nullable()->after('pet_age');
        });
    }
};
