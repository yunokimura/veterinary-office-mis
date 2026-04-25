<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign key constraint if exists
        try {
            DB::statement('ALTER TABLE adoption_selected_pets DROP FOREIGN KEY adoption_selected_pets_adoption_pet_id_foreign');
        } catch (Exception $e) {
            // Ignore if doesn't exist
        }

        // Drop the table (no longer needed; adoption pets are now in pets table)
        Schema::dropIfExists('adoption_selected_pets');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate table (cannot restore data)
        Schema::create('adoption_selected_pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adoption_application_id')->constrained('adoption_applications')->onDelete('cascade');
            $table->foreignId('adoption_pet_id')->constrained('adoption_pets')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
