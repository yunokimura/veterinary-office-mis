<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->string('clinic_name')->nullable()->after('recent_surgery');
            $table->string('vaccination_certificate')->nullable()->after('clinic_name');
            $table->string('vaccine_lot_number')->nullable()->after('vaccination_certificate');
        });
    }

    public function down(): void
    {
        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->dropColumn(['clinic_name', 'vaccination_certificate', 'vaccine_lot_number']);
        });
    }
};
