<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('spay_neuter_reports', 'spay_neuter_appointment_id')) {
            return;
        }

        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('spay_neuter_appointment_id')->nullable()->after('pet_id');
            $table->index('spay_neuter_appointment_id');
            $table->foreign('spay_neuter_appointment_id')
                ->references('id')
                ->on('spay_neuter_appointments')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->dropForeign(['spay_neuter_appointment_id']);
            $table->dropIndex(['spay_neuter_appointment_id']);
            $table->dropColumn('spay_neuter_appointment_id');
        });
    }
};
