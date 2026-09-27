<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->enum('status', ['pending_review', 'approved', 'rejected', 'adopted'])->default('pending_review')->change();
        });
    }

    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->enum('status', ['pending_review', 'approved', 'rejected'])->default('pending_review')->change();
        });
    }
};
