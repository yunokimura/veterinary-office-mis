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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('addressable_type', 50);
            $table->unsignedBigInteger('addressable_id');
            $table->string('block_lot_phase', 255)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('subdivision', 255)->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable()->index();
            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->nullOnDelete();
            $table->string('postal_code', 20)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['addressable_type', 'addressable_id'], 'addresses_polymorphic_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
