<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->string('animal_name')->nullable()->after('animal_status');
        });
    }

    public function down(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->dropColumn('animal_name');
        });
    }
};
