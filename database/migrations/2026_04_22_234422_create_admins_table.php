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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->unique();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->string('suffix', 20)->nullable();
            $table->enum('role_type', [
                'super_admin',
                'city_vet',
                'admin_staff',
                'admin_asst',
                'assistant_vet',
                'livestock_inspector',
                'meat_inspector',
            ]);
            $table->unsignedBigInteger('barangay_id')->nullable()->index();
            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->nullOnDelete();
            $table->string('contact_number', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
