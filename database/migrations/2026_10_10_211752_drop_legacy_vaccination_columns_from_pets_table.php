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
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['vaccination_status', 'vaccination_date', 'next_vaccination_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('vaccination_status')->nullable();
            $table->date('vaccination_date')->nullable();
            $table->date('next_vaccination_date')->nullable();
        });
    }
};
