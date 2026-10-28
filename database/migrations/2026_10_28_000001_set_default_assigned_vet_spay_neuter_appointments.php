<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spay_neuter_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_vet')->default(4)->nullable()->change();
        });

        DB::table('spay_neuter_appointments')
            ->whereNull('assigned_vet')
            ->update(['assigned_vet' => 4, 'veterinarian' => 'Assistant Veterinarian']);
    }

    public function down(): void
    {
        Schema::table('spay_neuter_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_vet')->default(null)->nullable()->change();
        });
    }
};
