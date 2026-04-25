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
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('selected_pet_id')->nullable()->after('shelter_visit');
            $table->foreign('selected_pet_id')->references('pet_id')->on('pets')->onDelete('set null');
            $table->index('selected_pet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->dropForeign(['selected_pet_id']);
            $table->dropColumn('selected_pet_id');
        });
    }
};
