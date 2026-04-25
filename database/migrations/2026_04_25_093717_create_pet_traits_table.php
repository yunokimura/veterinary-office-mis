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
        // Drop existing pet_traits table (old structure with adoption_pets references)
        Schema::dropIfExists('pet_traits');

        // Recreate as pivot between pets and traits
        Schema::create('pet_traits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade');
            $table->foreignId('trait_id')->constrained('traits')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['pet_id', 'trait_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_traits');
    }
};
