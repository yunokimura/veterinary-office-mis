<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Standardize inventory_controls.status enum values to lowercase snake_case
     * ('active', 'inactive', 'out_of_stock') and migrate existing title-case data.
     */
    public function up(): void
    {
        if (!Schema::hasTable('inventory_controls')) {
            return;
        }

        // Migrate existing title-case data to lowercase snake_case
        DB::statement("UPDATE inventory_controls SET status = 'active' WHERE status = 'Active'");
        DB::statement("UPDATE inventory_controls SET status = 'inactive' WHERE status = 'Inactive'");
        DB::statement("UPDATE inventory_controls SET status = 'out_of_stock' WHERE status = 'Out of Stock'");

        // Alter column enum to lowercase snake_case
        Schema::table('inventory_controls', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('inventory_controls')) {
            return;
        }

        // Migrate lowercase data back to title-case
        DB::statement("UPDATE inventory_controls SET status = 'Active' WHERE status = 'active'");
        DB::statement("UPDATE inventory_controls SET status = 'Inactive' WHERE status = 'inactive'");
        DB::statement("UPDATE inventory_controls SET status = 'Out of Stock' WHERE status = 'out_of_stock'");

        Schema::table('inventory_controls', function (Blueprint $table) {
            $table->enum('status', ['Active', 'Inactive', 'Out of Stock'])->default('Active')->change();
        });
    }
};
