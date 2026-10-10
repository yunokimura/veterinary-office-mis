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
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->boolean('not_vaccinated')->default(false);
            $table->json('vaccination_records')->nullable();
            $table->json('anti_rabies_details')->nullable();
            $table->string('vaccination_card_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->dropColumn([
                'not_vaccinated',
                'vaccination_records',
                'anti_rabies_details',
                'vaccination_card_path',
            ]);
        });
    }
};
