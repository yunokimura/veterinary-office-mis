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
            $table->unsignedBigInteger('pet_owner_id')->nullable()->after('user_id');
            $table->foreign('pet_owner_id')->references('owner_id')->on('pet_owners')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->dropForeign(['pet_owner_id']);
            $table->dropColumn('pet_owner_id');
        });
    }
};
