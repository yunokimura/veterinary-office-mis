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

        // 2. Migrate full_name data to first_name/last_name if full_name existed and has data
        // Check if first_name is null but full_name had data (rare edge case since full_name was just added)
        $usersWithFullName = DB::table('admin_users')
            ->whereNotNull('full_name')
            ->where('full_name', '!=', '')
            ->whereNull('first_name')
            ->get();

        foreach ($usersWithFullName as $user) {
            $nameParts = explode(' ', trim($user->full_name), 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            DB::table('admin_users')
                ->where('id', $user->id)
                ->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]);
        }

        // 3. Rename admin_users to users
        Schema::rename('admin_users', 'users');

        // 4. Update all FK constraints that reference admin_users(id) to now reference users(id)
        $this->updateForeignKeys();
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