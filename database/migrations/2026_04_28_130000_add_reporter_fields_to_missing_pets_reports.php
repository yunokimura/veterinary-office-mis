<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->string('report_type', 20)->default('missing')->after('status');
            $table->string('reported_by_name')->nullable()->after('report_type');
            $table->string('reporter_contact')->nullable()->after('reported_by_name');
            $table->string('reporter_email')->nullable()->after('reporter_contact');

            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('pet_id')->nullable()->change();

            $table->index('report_type');
        });
    }

    public function down(): void
    {
        Schema::table('missing_pets_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('pet_id')->nullable(false)->change();

            $table->dropColumn([
                'report_type',
                'reported_by_name',
                'reporter_contact',
                'reporter_email',
            ]);
        });
    }
};
