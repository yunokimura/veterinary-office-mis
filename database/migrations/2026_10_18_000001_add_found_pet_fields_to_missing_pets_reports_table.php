<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('collar_harness');
            $table->string('estimated_age')->nullable();
            $table->string('breed')->nullable();
            $table->string('fur_colors')->nullable();
            $table->string('condition')->nullable();
            $table->string('eye_color_left')->nullable();
            $table->string('eye_color_right')->nullable();
            $table->string('eye_color_other')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'estimated_age',
                'breed',
                'fur_colors',
                'condition',
                'eye_color_left',
                'eye_color_right',
                'eye_color_other',
            ]);
        });
    }
};
