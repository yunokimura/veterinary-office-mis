<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->enum('animal_status', ['stray', 'owned'])->default('stray')->change();
        });
    }

    public function down(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->enum('animal_status', ['stray', 'owned', 'wild'])->default('stray')->change();
        });
    }
};
