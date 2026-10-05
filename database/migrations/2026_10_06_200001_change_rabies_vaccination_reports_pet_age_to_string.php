<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rabies_vaccination_reports', function (Blueprint $table) {
            $table->string('pet_age', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('rabies_vaccination_reports', function (Blueprint $table) {
            $table->integer('pet_age')->nullable()->change();
        });
    }
};
