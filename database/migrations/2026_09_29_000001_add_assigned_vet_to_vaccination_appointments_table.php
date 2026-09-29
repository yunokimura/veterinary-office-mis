<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_vet')->nullable()->after('recent_surgery');
            $table->index('assigned_vet');
            $table->foreign('assigned_vet')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vaccination_appointments', function (Blueprint $table) {
            $table->dropForeign(['assigned_vet']);
            $table->dropIndex(['assigned_vet']);
            $table->dropColumn('assigned_vet');
        });
    }
};
