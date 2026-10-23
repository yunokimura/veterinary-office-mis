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
        Schema::create('guest_report_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();              // Str::random(32), 256-bit
            $table->string('pet_name')->nullable();
            $table->string('species')->nullable();          // 'dog' or 'cat'
            $table->boolean('is_crossbreed')->default(false);
            $table->string('reporter_contact')->nullable();
            $table->string('reporter_email')->nullable();   // From original report
            $table->timestamp('expires_at');                // 7 days from creation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_report_tokens');
    }
};
