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
        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('pet_id')->nullable()->after('id');
            $table->foreign('pet_id')->references('pet_id')->on('pets')->nullOnDelete();
            $table->index('pet_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->dropColumn(['metadata']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->json('metadata')->nullable()->after('status');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->dropForeign(['pet_id']);
            $table->dropIndex(['pet_id']);
            $table->dropColumn(['pet_id']);
        });
    }
};
