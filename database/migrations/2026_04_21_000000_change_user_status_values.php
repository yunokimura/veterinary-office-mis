<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Changes user status values: 'inactive' and 'suspended' become 'deactivated'
     * Enum values updated to ['active', 'deactivated']
     */
    public function up(): void
    {
        $tableName = Schema::hasTable('users') ? 'users' : 'admin_users';

        // Convert existing 'inactive' and 'suspended' to 'deactivated'
        DB::table($tableName)
            ->whereIn('status', ['inactive', 'suspended'])
            ->update(['status' => 'deactivated']);

        // Modify the enum column
        if (Schema::hasColumn($tableName, 'status')) {
            try {
                DB::statement("ALTER TABLE {$tableName} MODIFY COLUMN status ENUM('active', 'deactivated') DEFAULT 'active'");
            } catch (Exception $e) {
                Log::error("Failed to modify status enum on {$tableName}: ".$e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = Schema::hasTable('users') ? 'users' : 'admin_users';

        // Convert 'deactivated' back to 'inactive'
        DB::table($tableName)
            ->where('status', 'deactivated')
            ->update(['status' => 'inactive']);

        // Restore original enum with 'suspended'
        if (Schema::hasColumn($tableName, 'status')) {
            try {
                DB::statement("ALTER TABLE {$tableName} MODIFY COLUMN status ENUM('active', 'inactive', 'suspended') DEFAULT 'active'");
            } catch (Exception $e) {
                Log::error("Failed to revert status enum on {$tableName}: ".$e->getMessage());
            }
        }
    }
};
