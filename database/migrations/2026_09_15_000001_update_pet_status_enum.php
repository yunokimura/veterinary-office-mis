<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pets')
            ->whereNull('pet_status')
            ->orWhere('pet_status', '')
            ->orWhere('pet_status', 'available')
            ->update(['pet_status' => 'owned']);

        DB::statement("ALTER TABLE pets MODIFY COLUMN pet_status ENUM('owned', 'missing', 'for adoption', 'in shelter/intake', 'adopted', 'deceased') DEFAULT 'owned' NOT NULL");
    }

    public function down(): void
    {
        DB::table('pets')
            ->whereNotIn('pet_status', ['available', 'adopted', 'pending', 'unavailable', 'missing'])
            ->update(['pet_status' => 'available']);

        DB::statement("ALTER TABLE pets MODIFY COLUMN pet_status ENUM('available', 'adopted', 'pending', 'unavailable', 'missing') DEFAULT 'available' NOT NULL");
    }
};
