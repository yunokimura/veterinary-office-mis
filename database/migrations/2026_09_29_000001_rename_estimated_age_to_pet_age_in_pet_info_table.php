<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pet_info', function (Blueprint $table) {
            $table->renameColumn('estimated_age', 'pet_age');
        });
    }

    public function down(): void
    {
        Schema::table('pet_info', function (Blueprint $table) {
            $table->renameColumn('pet_age', 'estimated_age');
        });
    }
};
