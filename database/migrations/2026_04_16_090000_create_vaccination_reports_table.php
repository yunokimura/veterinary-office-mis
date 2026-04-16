<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vaccination_reports', function (Blueprint $table) {
            $table->id();
            
            // References
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('appointment_id')->nullable();
            
            // Owner Info
            $table->string('owner_first_name');
            $table->string('owner_last_name');
            $table->string('owner_email');
            $table->string('owner_contact');
            $table->string('alt_mobile_number')->nullable();
            $table->string('blk_lot_ph');
            $table->string('street');
            $table->string('barangay');
            
            // Appointment
            $table->datetime('scheduled_at');
            
            // Medical History
            $table->date('last_anti_rabies_date')->nullable();
            $table->boolean('recent_surgery')->default(false);
            
            // Status
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled', 'no_show'])->default('pending');
            
            // Flexible data
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('scheduled_at');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccination_reports');
    }
};