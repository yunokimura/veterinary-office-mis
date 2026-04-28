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
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('pet_id')->nullable()->after('user_id');
            $table->foreign('pet_id')
                ->references('pet_id')
                ->on('pets')
                ->onDelete('set null');
            $table->index('pet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->dropForeign(['pet_id']);
            $table->dropColumn('pet_id');
        });
    }
};
