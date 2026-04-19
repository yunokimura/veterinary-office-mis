<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pet_traits', 'adoption_id')) {
            Schema::table('pet_traits', function (Blueprint $table) {
                $table->unsignedBigInteger('adoption_id')->nullable()->after('id');
                $table->foreign('adoption_id')->references('adoption_id')->on('adoption_pets')->onDelete('cascade');
                $table->index('adoption_id');
            });

            if (Schema::hasColumn('pet_traits', 'pet_id')) {
                DB::statement('UPDATE pet_traits pt
                    INNER JOIN pets p ON p.pet_id = pt.pet_id AND p.source_module = "adoption_pets"
                    SET pt.adoption_id = p.source_module_id
                    WHERE pt.adoption_id IS NULL');
            }
        }
    }

    public function down(): void
    {
        Schema::table('pet_traits', function (Blueprint $table) {
            $table->dropForeign(['adoption_id']);
            $table->dropColumn(['adoption_id']);
        });
    }
};
