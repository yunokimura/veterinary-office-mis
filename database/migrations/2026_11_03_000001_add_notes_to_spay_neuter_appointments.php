<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('spay_neuter_appointments', 'notes')) {
            Schema::table('spay_neuter_appointments', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('veterinarian');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('spay_neuter_appointments', 'notes')) {
            Schema::table('spay_neuter_appointments', function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
};
