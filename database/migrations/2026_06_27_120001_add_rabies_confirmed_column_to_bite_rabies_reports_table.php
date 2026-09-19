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
        Schema::table('rabies_reports', function (Blueprint $table) {
            // Add rabies_confirmed column as boolean
            $table->boolean('rabies_confirmed')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->dropColumn('rabies_confirmed');
        });
    }
};