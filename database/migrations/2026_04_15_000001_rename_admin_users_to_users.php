<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop full_name column if exists
        if (Schema::hasColumn('admin_users', 'full_name')) {
            Schema::table('admin_users', function (Blueprint $table) {
                $table->dropColumn('full_name');
            });
        }

        // 2. Handle the case where both 'users' and 'admin_users' tables exist
        // This happens if migration 2026_04_08 didn't properly rename
        if (Schema::hasTable('users') && Schema::hasTable('admin_users')) {
            // Drop the old default users table (it's redundant)
            Schema::dropIfExists('users');
        }

        // 3. Rename admin_users to users if admin_users exists and users doesn't
        if (Schema::hasTable('admin_users') && !Schema::hasTable('users')) {
            Schema::rename('admin_users', 'users');
        } elseif (!Schema::hasTable('admin_users') && Schema::hasTable('users')) {
            // Already renamed or users is the main table - nothing to do
        }

        // 4. Update all FK constraints that reference admin_users(id) to now reference users(id)
        if (Schema::hasTable('users')) {
            $this->updateForeignKeys();
        }
    }

    private function updateForeignKeys(): void
    {
        $tableReferences = [
            'adoption_status_histories' => 'updated_by_user_id',
            'barangay_users' => 'user_id',
            'bite_rabies_reports' => 'user_id',
            'bite_rabies_reports' => 'reported_by',
            'bite_rabies_reports' => 'approved_by',
            'device_tokens' => 'user_id',
            'establishments' => 'user_id',
            'exposure_cases' => 'user_id',
            'form_submissions' => 'user_id',
            'form_submissions' => 'submitted_by',
            'impound_status_histories' => 'updated_by_user_id',
            'impounds' => 'user_id',
            'impounds' => 'captured_by_user_id',
            'livestock' => 'recorded_by',
            'livestock_censuses' => 'encoded_by_user_id',
            'meat_establishments' => 'user_id',
            'meat_inspections' => 'user_id',
            'meat_shop_inspections' => 'user_id',
            'medical_records' => 'user_id',
            'notifications' => 'user_id',
            'rabies_cases' => 'user_id',
            'report_exports' => 'exported_by_user_id',
            'service_forms' => 'user_id',
            'sessions' => 'user_id',
            'stray_reports' => 'reported_by_user_id',
            'system_logs' => 'user_id',
            'vaccinations' => 'vaccinated_by',
            'announcements' => 'created_by',
            'announcement_reads' => 'user_id',
            'facilities' => 'created_by',
            'facilities' => 'updated_by',
            'inventory_controls' => 'created_by',
            'inventory_controls' => 'performed_by',
            'clinical_actions' => 'user_id',
            'adoption_applications' => 'user_id',
            'missing_pets_reports' => 'user_id',
            'pet_owners' => 'user_id',
            'adoption_selected_pets' => 'user_id',
            'adoption_applications' => 'user_id',
            'rabies_vaccination_reports' => 'user_id',
        ];

        foreach ($tableReferences as $table => $column) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            if (!Schema::hasColumn($table, $column)) {
                continue;
            }

            try {
                $fkName = $this->getForeignKeyName($table, $column);
                if ($fkName) {
                    DB::statement("ALTER TABLE {$table} DROP FOREIGN KEY {$fkName}");
                    DB::statement("ALTER TABLE {$table} ADD CONSTRAINT {$fkName} FOREIGN KEY ({$column}) REFERENCES users(id) ON DELETE SET NULL");
                }
            } catch (\Exception $e) {
                // FK might not exist or already updated
            }
        }
    }

    private function getForeignKeyName(string $table, string $column): ?string
    {
        $results = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = '{$table}' 
            AND COLUMN_NAME = '{$column}'
        ");
        
        return $results[0]->CONSTRAINT_NAME ?? null;
    }

    public function down(): void
    {
        // Rename users back to admin_users
        Schema::rename('users', 'admin_users');

        // Restore FK constraints referencing admin_users
        $tableReferences = [
            'adoption_status_histories' => 'updated_by_user_id',
            'barangay_users' => 'user_id',
            'bite_rabies_reports' => 'user_id',
            'device_tokens' => 'user_id',
            'establishments' => 'user_id',
            'form_submissions' => 'user_id',
            'impounds' => 'user_id',
            'livestock' => 'recorded_by',
            'meat_establishments' => 'user_id',
            'meat_inspections' => 'user_id',
            'notifications' => 'user_id',
            'sessions' => 'user_id',
            'stray_reports' => 'reported_by_user_id',
            'system_logs' => 'user_id',
            'vaccinations' => 'vaccinated_by',
        ];

        foreach ($tableReferences as $table => $column) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            if (!Schema::hasColumn($table, $column)) {
                continue;
            }

            try {
                $fkName = $this->getForeignKeyName($table, $column);
                if ($fkName) {
                    DB::statement("ALTER TABLE {$table} DROP FOREIGN KEY {$fkName}");
                    DB::statement("ALTER TABLE {$table} ADD CONSTRAINT {$fkName} FOREIGN KEY ({$column}) REFERENCES admin_users(id) ON DELETE SET NULL");
                }
            } catch (\Exception $e) {
                // Ignore
            }
        }
    }
};