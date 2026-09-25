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

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->dropColumn([
                'user_id',
                'owner_id',
                'address_id',
                'appointment_id',
                'scheduled_at',
                'last_anti_rabies_date',
                'recent_surgery',
                'metadata',
            ]);
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('vaccination_appointment_id')->nullable()->after('id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->foreignId('pet_id')->nullable()->constrained('pets', 'pet_id')->nullOnDelete()->after('vaccination_appointment_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id')->nullable()->after('pet_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('pet_name')->nullable()->after('barangay_id');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('pet_species')->nullable()->after('pet_name');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('pet_breed')->nullable()->after('pet_species');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('pet_gender')->nullable()->after('pet_breed');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->integer('pet_age')->nullable()->after('pet_gender');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('pet_color')->nullable()->after('pet_age');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('vaccine_brand')->nullable()->after('pet_color');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('vaccine_batch_number')->nullable()->after('vaccine_brand');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->date('vaccination_date')->nullable()->after('vaccine_batch_number');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->time('vaccination_time')->nullable()->after('vaccination_date');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->date('next_vaccination_date')->nullable()->after('vaccination_time');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->decimal('weight', 8, 2)->nullable()->after('next_vaccination_date');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('vaccination_type')->nullable()->after('weight');
        });

        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('status')->default('completed')->after('vaccination_type')->change();
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

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

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
            $table->string('status')->default('pending')->after('metadata')->change();
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

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
