<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pet_traits', 'trait_id')) {
            Schema::table('pet_traits', function (Blueprint $table) {
                $table->foreignId('trait_id')->nullable()->constrained('traits')->onDelete('cascade');
                $table->index('trait_id');
            });

            // Migrate existing data: link traits by name
            DB::statement('UPDATE pet_traits pt
                INNER JOIN traits t ON t.name = pt.name
                SET pt.trait_id = t.id
                WHERE pt.trait_id IS NULL');
        }
    }

    public function down(): void
    {
        Schema::table('pet_traits', function (Blueprint $table) {
            $table->dropForeign(['trait_id']);
            $table->dropColumn(['trait_id']);
        });
    }
};
