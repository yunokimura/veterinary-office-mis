<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('spay_neuter_appointments', 'previous_surgery_date')) {
            Schema::table('spay_neuter_appointments', function (Blueprint $table) {
                $table->date('previous_surgery_date')->nullable()->after('notes');
                $table->string('surgery_type')->nullable()->after('previous_surgery_date');
                $table->date('is_ineligible_until')->nullable()->after('surgery_type');
                $table->index('is_ineligible_until');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('spay_neuter_appointments', 'previous_surgery_date')) {
            Schema::table('spay_neuter_appointments', function (Blueprint $table) {
                $table->dropColumn(['previous_surgery_date', 'surgery_type', 'is_ineligible_until']);
            });
        }
    }
};
