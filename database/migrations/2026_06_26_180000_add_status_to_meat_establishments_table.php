<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('meat_establishments', function (Blueprint $table) {
            $table->enum('status', ['Active', 'Expired', 'Pending Inspection'])->default('Active')->after('registered_by_user_id');
            $table->date('permit_expiry_date')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meat_establishments', function (Blueprint $table) {
            $table->dropColumn(['status', 'permit_expiry_date']);
        });
    }
};