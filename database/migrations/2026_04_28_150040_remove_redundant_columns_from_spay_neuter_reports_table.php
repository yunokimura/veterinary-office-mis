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
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->dropColumn([
                'pet_name',
                'pet_breed',
                'pet_age',
                'gender',
                'species',
                'owner_name',
                'owner_contact',
                'owner_address',
                'clinic_name',
                'barangay',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->string('pet_name')->nullable()->after('user_id');
            $table->string('pet_breed')->nullable()->after('pet_name');
            $table->string('pet_age')->nullable()->after('pet_breed');
            $table->string('gender')->nullable()->after('pet_age');
            $table->string('species')->nullable()->after('gender');
            $table->string('owner_name')->after('species');
            $table->string('owner_contact')->nullable()->after('owner_name');
            $table->text('owner_address')->nullable()->after('owner_contact');
            $table->string('clinic_name')->nullable()->after('owner_address');
            $table->string('barangay')->nullable()->after('clinic_name');
        });
    }
};
