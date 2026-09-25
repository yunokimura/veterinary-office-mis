<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::statement('ALTER TABLE vaccination_appointments DROP INDEX vaccinations_pet_id_index');
        DB::statement('ALTER TABLE vaccination_appointments DROP INDEX vaccinations_vaccinated_by_index');
        DB::statement('ALTER TABLE vaccination_appointments DROP INDEX vaccinations_vaccination_date_index');

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->dropColumn([
                'pet_id',
                'vaccinated_by',
                'vaccine_type',
                'vaccination_date',
                'next_vaccination_date',
                'batch_number',
                'veterinarian',
                'notes',
            ]);
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->nullable()->after('user_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('address_id')->nullable()->after('owner_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->dateTime('scheduled_at')->nullable()->after('address_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('scheduled_at');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->json('metadata')->nullable()->after('status');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->date('last_anti_rabies_date')->nullable()->after('metadata');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->boolean('recent_surgery')->default(false)->after('last_anti_rabies_date');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->index('owner_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->index('address_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->index('scheduled_at');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->index('status');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->dropColumn([
                'user_id',
                'owner_id',
                'address_id',
                'scheduled_at',
                'status',
                'metadata',
                'last_anti_rabies_date',
                'recent_surgery',
            ]);
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('pet_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('vaccinated_by');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->string('vaccine_type')->default('Rabies');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->date('vaccination_date');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->date('next_vaccination_date')->nullable();
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->string('batch_number')->nullable();
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->string('veterinarian')->nullable();
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->text('notes')->nullable();
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->index('pet_id');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->index('vaccinated_by');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->index('vaccination_date');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade');
        });

        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->foreign('vaccinated_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::rename('vaccination_appointments', 'vaccinations');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
