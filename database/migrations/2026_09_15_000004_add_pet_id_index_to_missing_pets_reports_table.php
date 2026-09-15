<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missing_pets_reports', function ($table) {
            $table->index('pet_id', 'idx_missing_pets_reports_pet_id');
        });
    }

    public function down(): void
    {
        Schema::table('missing_pets_reports', function ($table) {
            $table->dropIndex('idx_missing_pets_reports_pet_id');
        });
    }
};
