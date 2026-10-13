<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('spay_neuter_appointments')) {
            return;
        }

        Schema::create('spay_neuter_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->string('status')->default('pending');
            $table->string('procedure_type')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->json('general_agreement')->nullable();
            $table->string('veterinarian')->nullable();
            $table->unsignedBigInteger('assigned_vet')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('owner_id');
            $table->index('address_id');
            $table->index('barangay_id');
            $table->index('assigned_vet');
            $table->index(['pet_id', 'status', 'scheduled_at'], 'sn_appt_pet_status_sched_idx');

            $table->foreign('assigned_vet')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spay_neuter_appointments');
    }
};
