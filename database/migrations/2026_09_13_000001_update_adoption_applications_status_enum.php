<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->enum('status', ['pending', 'pending_review', 'approved', 'rejected', 'completed'])->default('pending')->change();
        });

        DB::statement("UPDATE adoption_applications SET status = 'approved' WHERE status = 'completed'");
        DB::statement("UPDATE adoption_applications SET status = 'pending_review' WHERE status = 'pending'");

        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->enum('status', ['pending_review', 'approved', 'rejected'])->default('pending_review')->change();
        });
    }

    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->enum('status', ['pending', 'pending_review', 'approved', 'rejected', 'completed'])->default('pending')->change();
        });

        DB::statement("UPDATE adoption_applications SET status = 'pending' WHERE status = 'pending_review'");
        DB::statement("UPDATE adoption_applications SET status = 'completed' WHERE status = 'approved' AND valid_id_path IS NOT NULL");

        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }
};
