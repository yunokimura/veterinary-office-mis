<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_controls', function (Blueprint $table) {
            if (!Schema::hasColumn('inventory_controls', 'item_code')) {
                $table->string('item_code')->unique()->nullable()->after('item_name');
            }

            if (!Schema::hasColumn('inventory_controls', 'batch_number')) {
                $table->string('batch_number')->nullable()->after('expiry_date');
            }
            if (!Schema::hasColumn('inventory_controls', 'supplier')) {
                $table->string('supplier')->nullable()->after('batch_number');
            }
            if (!Schema::hasColumn('inventory_controls', 'storage_location')) {
                $table->string('storage_location')->nullable()->after('supplier');
            }

            if (Schema::hasColumn('inventory_controls', 'unit_price')) {
                $table->renameColumn('unit_price', 'unit_cost');
            }

            if (Schema::hasColumn('inventory_controls', 'barangay_id')) {
                $table->dropForeign(['barangay_id']);
                $table->dropColumn('barangay_id');
            }

            $existingIndexes = DB::select("SHOW INDEXES FROM inventory_controls WHERE Key_name = 'inventory_controls_expiry_date_index'");
            if (empty($existingIndexes)) {
                $table->index('expiry_date');
            }
        });

        Schema::table('inventory_movements', function (Blueprint $table) {
            if (!Schema::hasColumn('inventory_movements', 'reference_number')) {
                $table->string('reference_number')->nullable()->after('reason');
            }
            if (!Schema::hasColumn('inventory_movements', 'movement_reason')) {
                $table->string('movement_reason')->nullable()->after('movement_type');
            }

            if (Schema::hasColumn('inventory_movements', 'barangay_id')) {
                $table->dropForeign(['barangay_id']);
                $table->renameColumn('barangay_id', 'target_barangay_id');
                $table->foreign('target_barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
                $table->dropIndex(['barangay_id']);
            }

            $existingIndexes = DB::select("SHOW INDEXES FROM inventory_movements WHERE Key_name = 'inventory_movements_target_barangay_id_index'");
            if (empty($existingIndexes)) {
                $table->index('target_barangay_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            if (Schema::hasColumn('inventory_movements', 'target_barangay_id')) {
                $table->dropForeign(['target_barangay_id']);
                $table->dropIndex(['target_barangay_id']);
                $table->renameColumn('target_barangay_id', 'barangay_id');
                $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
            }

            $table->dropColumn(['reference_number', 'movement_reason']);
        });

        Schema::table('inventory_controls', function (Blueprint $table) {
            if (!Schema::hasColumn('inventory_controls', 'barangay_id')) {
                $table->unsignedBigInteger('barangay_id')->nullable();
                $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('set null');
            }

            $table->dropColumn(['item_code', 'batch_number', 'supplier', 'storage_location']);

            if (Schema::hasColumn('inventory_controls', 'unit_cost')) {
                $table->renameColumn('unit_cost', 'unit_price');
            }

            $table->dropIndex(['expiry_date']);
        });
    }
};
