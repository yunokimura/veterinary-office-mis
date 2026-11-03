<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('adoption_applications', 'notes')) {
            Schema::table('adoption_applications', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('appointment_time');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('adoption_applications', 'notes')) {
            Schema::table('adoption_applications', function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
};
