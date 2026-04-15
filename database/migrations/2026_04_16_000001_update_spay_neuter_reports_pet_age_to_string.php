<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change pet_age from integer to string to store formatted age like "5 months" or "2 years"
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            // First drop the column, then add as string
            $table->string('pet_age', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->integer('pet_age')->nullable()->change();
        });
    }
};