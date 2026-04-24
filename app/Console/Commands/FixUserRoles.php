<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FixUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:fix-roles 
                            {--dry-run : Preview changes without saving}
                            {--delete-orphans : Delete users with no Spatie role and orphaned role value}
                            {--force : Skip confirmation for deletions}
                            {--protected-emails= : Comma-separated list of emails to protect from deletion}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync users.role column with Spatie roles and optionally delete orphaned accounts';

    /**
     * Protected account emails (never delete).
     */
    protected array $protectedEmails = [
        'superadmin@vetmis.gov',
        'cityvet@vetmis.gov',
        'assistantvet@vetmis.gov',
        'livestock@vetmis.gov',
        'meatinspector@vetmis.gov',
        'adminasst@vetmis.gov',
        'clinic@vetmis.gov',
        'hospital@vetmis.gov',
        'sawkevin581@gmail.com',
        'keryuxo@gmail.com',
    ];

    /**
     * Orphaned role values that trigger deletion.
     */
    protected array $orphanRoleValues = [
        'viewer',
        'admin_asst',
        'barangay_encoder',
        'city_pound',
        'disease_control',
    ];

    /**
     * Expected Spatie roles for protected accounts.
     */
    protected array $protectedRoleMap = [
        'superadmin@vetmis.gov' => 'super_admin',
        'cityvet@vetmis.gov' => 'city_vet',
        'assistantvet@vetmis.gov' => 'assistant_vet',
        'livestock@vetmis.gov' => 'livestock_inspector',
        'meatinspector@vetmis.gov' => 'meat_inspector',
        'adminasst@vetmis.gov' => 'admin_asst',
        'clinic@vetmis.gov' => 'clinic',
        'hospital@vetmis.gov' => 'hospital',
        'sawkevin581@gmail.com' => 'pet_owner',
        'keryuxo@gmail.com' => 'pet_owner',
    ];

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $deleteOrphans = $this->option('delete-orphans');
        $force = $this->option('force');
        $protectedEmailsOption = $this->option('protected-emails');

        if ($dryRun) {
            $this->info('[DRY RUN] No changes will be saved.');
        }

        // Merge custom protected emails
        if ($protectedEmailsOption) {
            $custom = array_map('trim', explode(',', $protectedEmailsOption));
            $this->protectedEmails = array_unique(array_merge($this->protectedEmails, $custom));
        }

        $logFile = storage_path('logs/role-fix-'.now()->format('Y-m-d-His').'.log');
        $this->info("Log will be written to: {$logFile}");

        try {
            // Step 1: Sync all user roles
            $this->syncAllRoles($dryRun);

            // Step 2: Verify and fix protected accounts
            $this->verifyProtectedAccounts($dryRun);

            // Step 3: Delete orphaned accounts if requested
            $deletedCount = 0;
            if ($deleteOrphans) {
                $deletedCount = $this->deleteOrphanedAccounts($dryRun, $force);
            }

            if (! $dryRun) {
                $this->info('✅ Role fix completed. Users synced.');
                if ($deleteOrphans) {
                    $this->info("🗑️  Orphaned accounts deleted: {$deletedCount}");
                }
            } else {
                $this->info('[DRY RUN] completed. Use without --dry-run to apply changes.');
            }

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('❌ Failed: '.$e->getMessage());
            Log::error('users:fix-roles failed', ['exception' => $e]);

            return Command::FAILURE;
        }
    }

    private function syncAllRoles(bool $dryRun): void
    {
        $this->info('Syncing users.role with Spatie roles...');
        $users = User::with('roles')->get();
        $fixed = 0;
        $already = 0;

        foreach ($users as $user) {
            $primaryRole = $user->roles->first()?->name;
            $currentColumn = $user->getAttribute('role');

            if ($primaryRole) {
                if ($currentColumn !== $primaryRole) {
                    if (! $dryRun) {
                        $user->update(['role' => $primaryRole]);
                    }
                    $fixed++;
                } else {
                    $already++;
                }
            } else {
                // No Spatie role assigned
                if ($currentColumn !== null) {
                    if (! $dryRun) {
                        $user->update(['role' => null]);
                    }
                    $fixed++;
                }
            }
        }

        $status = $dryRun ? '(DRY RUN)' : '';
        $this->info("  {$status} Fixed: {$fixed}, Already correct: {$already}");
    }

    private function verifyProtectedAccounts(bool $dryRun): void
    {
        $this->info('Verifying protected accounts...');
        $updated = 0;

        foreach ($this->protectedRoleMap as $email => $expectedRole) {
            $user = User::where('email', $email)->first();
            if (! $user) {
                $this->warn("  ⚠️  Protected user not found: {$email}");

                continue;
            }

            // Check Spatie role
            $hasRole = $user->hasRole($expectedRole);
            if (! $hasRole) {
                if (! $dryRun) {
                    $user->syncRoles([$expectedRole]);
                }
                $this->line("  [PROTECTED] Assigned role '{$expectedRole}' to {$email}");
            }

            // Ensure column syncs
            if ($user->getAttribute('role') !== $expectedRole) {
                if (! $dryRun) {
                    $user->update(['role' => $expectedRole]);
                }
                $updated++;
            }
        }

        if ($updated > 0) {
            $status = $dryRun ? '(DRY RUN)' : '';
            $this->info("  {$status} Updated {$updated} protected account role columns.");
        } else {
            $this->info('  All protected accounts already have correct roles.');
        }
    }

    private function deleteOrphanedAccounts(bool $dryRun, bool $force): int
    {
        $this->info('Identifying orphaned accounts for deletion...');

        // Orphan: No Spatie roles AND role column in deletion list AND not protected
        $orphanQuery = User::whereDoesntHave('roles') // no Spatie roles assigned
            ->whereIn('role', $this->orphanRoleValues)
            ->whereNotIn('email', $this->protectedEmails);

        $orphans = $orphanQuery->get();
        // Already filtered by query; no need for second filter
        $toDelete = $orphans;

        $orphans = $orphanQuery->get();
        $toDelete = $orphans->filter(function ($user) {
            // Double-check: must have no Spatie roles AND role column is orphan value
            $hasSpatieRoles = $user->roles()->exists();
            $isOrphanRole = in_array($user->role, $this->orphanRoleValues);

            return ! $hasSpatieRoles && $isOrphanRole;
        });

        if ($toDelete->isEmpty()) {
            $this->info('  No orphaned accounts found to delete.');

            return 0;
        }

        $this->warn("  Found {$toDelete->count()} orphaned accounts:");
        foreach ($toDelete as $u) {
            $this->line("    - {$u->email} (ID: {$u->id}, role: {$u->role})");
        }

        if ($dryRun) {
            $this->info('  [DRY RUN] Would delete these accounts. Run without --dry-run to confirm.');

            return 0;
        }

        if (! $force && ! $this->confirm('Are you sure you want to DELETE these accounts permanently?')) {
            $this->info('  Deletion cancelled by user.');

            return 0;
        }

        // Backup to CSV first
        $backupDir = storage_path('app/role-fix-backups');
        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        $backupFile = $backupDir.'/orphaned-'.now()->format('Y-m-d').'.csv';
        $handle = fopen($backupFile, 'w');
        fputcsv($handle, ['id', 'email', 'first_name', 'middle_name', 'last_name', 'created_at', 'status', 'role']);
        foreach ($toDelete as $u) {
            fputcsv($handle, [
                $u->id,
                $u->email,
                $u->first_name,
                $u->middle_name,
                $u->last_name,
                $u->created_at,
                $u->status,
                $u->role,
            ]);
        }
        fclose($handle);
        $this->info("  Backup saved to: {$backupFile}");

        // Soft-delete by setting status = 'deactivated' (preserve data)
        foreach ($toDelete as $user) {
            $user->update([
                'status' => 'deactivated',
            ]);
            // Optionally add a deleted_reason column if exists, else just status change
        }

        $this->info("  Soft-deleted {$toDelete->count()} accounts (status set to 'deactivated').");
        $this->info('  NOTE: Hard deletion should be done after 30-day review period.');

        return $toDelete->count();
    }
}
