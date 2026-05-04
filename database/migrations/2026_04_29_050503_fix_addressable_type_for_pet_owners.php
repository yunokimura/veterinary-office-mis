<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix old addressable_type values to use the morph map alias 'pet_owner'
        DB::table('addresses')
            ->where('addressable_type', 'App\Models\PetOwner')
            ->update(['addressable_type' => 'pet_owner']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original class name for addresses that were fixed
        DB::table('addresses')
            ->where('addressable_type', 'pet_owner')
            ->update(['addressable_type' => 'App\Models\PetOwner']);
    }
};
