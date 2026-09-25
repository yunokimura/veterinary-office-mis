<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('status')->default('completed')->change();
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->text('observations')->nullable()->after('status');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('observations');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('administered_by')->nullable()->after('notes');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('inventory_control_id')->nullable()->after('administered_by');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('vaccination_appointment_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('pet_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('barangay_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('vaccination_date');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('inventory_control_id');
        });
    }

    public function down(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->dropColumn([
                'vaccination_appointment_id',
                'pet_id',
                'barangay_id',
                'pet_name',
                'pet_species',
                'pet_breed',
                'pet_gender',
                'pet_age',
                'pet_color',
                'vaccine_brand',
                'vaccine_batch_number',
                'vaccination_date',
                'vaccination_time',
                'next_vaccination_date',
                'weight',
                'vaccination_type',
                'observations',
                'notes',
                'administered_by',
                'inventory_control_id',
            ]);
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled', 'no_show'])->default('pending')->change();
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('address_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id')->nullable();
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->dateTime('scheduled_at');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->date('last_anti_rabies_date')->nullable();
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->boolean('recent_surgery')->default(false);
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->json('metadata')->nullable();
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('scheduled_at');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->index('status');
        });
    }
};
