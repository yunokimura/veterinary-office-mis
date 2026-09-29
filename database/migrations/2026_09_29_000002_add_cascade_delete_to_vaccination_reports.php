<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->foreign('vaccination_appointment_id')
                ->references('id')
                ->on('vaccination_appointments')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->dropForeign(['vaccination_appointment_id']);
        });
    }
};
