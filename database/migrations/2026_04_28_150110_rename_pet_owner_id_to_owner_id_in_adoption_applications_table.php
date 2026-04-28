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
            // Drop existing foreign key
            $table->dropForeign(['pet_owner_id']);
            // Rename column to owner_id
            $table->renameColumn('pet_owner_id', 'owner_id');
            // Re-add foreign key referencing pet_owners.owner_id
            $table->foreign('owner_id')
                ->references('owner_id')
                ->on('pet_owners')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            // Drop the foreign key
            $table->dropForeign(['owner_id']);
            // Rename back to pet_owner_id
            $table->renameColumn('owner_id', 'pet_owner_id');
            // Re-add original foreign key
            $table->foreign('pet_owner_id')
                ->references('owner_id')
                ->on('pet_owners')
                ->onDelete('set null');
        });
    }
};
