<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('reporter_email');
        });
    }

    public function down(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->dropColumn('photo_path');
        });
    }
};
