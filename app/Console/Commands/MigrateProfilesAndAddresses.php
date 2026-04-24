<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Barangay;
use App\Models\Organization;
use App\Models\PetOwner;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateProfilesAndAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-profiles 
                            {--dry-run : Preview changes without saving}
                            {--force : Skip confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate profile data from users table to normalized tables (admins, organizations, addresses)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting profile and address migration...');
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        if (! $dryRun && ! $force) {
            $this->warn('This will modify your database. Use --dry-run to preview or --force to skip confirmation.');
            if (! $this->confirm('Do you want to continue?')) {
                $this->info('Migration cancelled.');

                return Command::SUCCESS;
            }
        }

        if ($dryRun) {
            $this->info('[DRY RUN] No changes will be saved.');
        }

        try {
            DB::beginTransaction();

            // Step 1: Migrate Admin Staff
            $this->migrateAdmins($dryRun);

            // Step 2: Migrate Organizations (clinics/hospitals)
            $this->migrateOrganizations($dryRun);

            // Step 3: Migrate Pet Owner Addresses
            $this->migratePetOwnerAddresses($dryRun);

            // Step 4: Migrate Admin Addresses
            $this->migrateAdminAddresses($dryRun);

            // Step 5: Migrate Organization Addresses
            $this->migrateOrganizationAddresses($dryRun);

            // Step 6: Consolidate Pet Owner Emails into users.email
            $emailConflicts = $this->consolidatePetOwnerEmails($dryRun);

            if (! empty($emailConflicts) && $dryRun) {
                $this->warn('[DRY RUN] Would have '.count($emailConflicts).' email conflicts');
            }

            if (! $dryRun) {
                DB::commit();
                $this->info('✅ Migration completed successfully!');

                if (! empty($emailConflicts)) {
                    $this->warn('⚠️  '.count($emailConflicts).' email conflicts require manual resolution.');
                    $this->info('Conflicts logged to: storage/app/email_conflicts.json');
                }
            } else {
                $this->info('[DRY RUN] completed. No changes committed.');
            }

            return Command::SUCCESS;
        } catch (Exception $e) {
            DB::rollBack();
            $this->error('❌ Migration failed: '.$e->getMessage());
            Log::error('Profile migration failed', ['exception' => $e]);

            return Command::FAILURE;
        }
    }

    private function migrateAdmins(bool $dryRun): void
    {
        $this->info('Step 1: Migrating admin staff to admins table...');
        $adminRoles = ['super_admin', 'city_vet', 'admin_staff', 'admin_asst', 'assistant_vet', 'livestock_inspector', 'meat_inspector'];

        $users = User::whereHas('roles', fn ($q) => $q->whereIn('name', $adminRoles))
            ->with('roles')
            ->get();

        $count = 0;
        foreach ($users as $user) {
            $primaryRole = $user->roles->first()->name;

            if ($dryRun) {
                $this->line("  [DRY] Would create admin for user {$user->id} ({$user->email}) role: {$primaryRole}");
            } else {
                Admin::create([
                    'user_id' => $user->id,
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name,
                    'last_name' => $user->last_name,
                    'suffix' => null,
                    'role_type' => $primaryRole,
                    'barangay_id' => $user->barangay_id,
                    'contact_number' => $user->contact_number,
                    'date_of_birth' => null,
                ]);
            }
            $count++;
        }

        $status = $dryRun ? '(DRY RUN)' : '';
        $this->info("  {$status} Migrated {$count} admin users.");
    }

    private function migrateOrganizations(bool $dryRun): void
    {
        $this->info('Step 2: Migrating organizations (clinics/hospitals)...');
        $orgRoles = ['clinic', 'hospital'];

        $users = User::whereHas('roles', fn ($q) => $q->whereIn('name', $orgRoles))
            ->with('roles')
            ->get();

        $count = 0;
        foreach ($users as $user) {
            $primaryRole = $user->roles->first()->name;

            if ($dryRun) {
                $this->line("  [DRY] Would create {$primaryRole} organization for user {$user->id} ({$user->email})");
            } else {
                $org = Organization::create([
                    'type' => $primaryRole,
                    'name' => $user->first_name ?: $user->email, // org name from user's name
                    'contact_user_id' => $user->id,
                    'contact_number' => $user->contact_number,
                    'official_email' => $user->email,
                    'is_active' => $user->status === 'active',
                ]);
                $user->update(['organization_id' => $org->id]);
            }
            $count++;
        }

        $status = $dryRun ? '(DRY RUN)' : '';
        $this->info("  {$status} Migrated {$count} organizations.");
    }

    private function migratePetOwnerAddresses(bool $dryRun): void
    {
        $this->info('Step 3: Migrating pet owner addresses...');
        $petOwners = PetOwner::with('user')->get();
        $total = $petOwners->count();

        if ($dryRun) {
            $this->line("  [DRY] Would create addresses for {$total} pet owners");

            return;
        }

        $barangayCache = [];
        $created = 0;
        $skipped = 0;

        foreach ($petOwners as $po) {
            try {
                $barangayId = null;
                if ($po->barangay) {
                    $key = strtolower(trim($po->barangay));
                    if (! isset($barangayCache[$key])) {
                        $brgy = Barangay::whereRaw('LOWER(barangay_name) LIKE ?', ["%{$key}%"])->first();
                        $barangayCache[$key] = $brgy?->barangay_id;
                    }
                    $barangayId = $barangayCache[$key];
                }

                $address = Address::create([
                    'addressable_type' => 'pet_owner',
                    'addressable_id' => $po->owner_id,
                    'block_lot_phase' => $po->blk_lot_ph,
                    'street' => $po->street,
                    'subdivision' => $po->subdivision,
                    'barangay_id' => $barangayId,
                    'city' => $po->city,
                    'province' => $po->province,
                    'postal_code' => null,
                    'is_primary' => true,
                ]);

                $po->update(['address_id' => $address->id]);
                $created++;
            } catch (Exception $e) {
                $this->warn("  Failed to create address for pet_owner ID {$po->owner_id}: ".$e->getMessage());
                $skipped++;
            }
        }

        $this->info("  Created {$created} addresses, skipped {$skipped}.");
    }

    private function migrateAdminAddresses(bool $dryRun): void
    {
        $this->info('Step 4: Migrating admin addresses...');
        $admins = Admin::with('user')->get();
        $total = $admins->count();

        if ($dryRun) {
            $this->line("  [DRY] Would create addresses for {$total} admins");

            return;
        }

        $created = 0;
        foreach ($admins as $admin) {
            if ($admin->user->address || $admin->barangay_id) {
                try {
                    Address::create([
                        'addressable_type' => 'admin',
                        'addressable_id' => $admin->id,
                        'block_lot_phase' => $admin->user->address,
                        'street' => null,
                        'subdivision' => null,
                        'barangay_id' => $admin->barangay_id,
                        'city' => null,
                        'province' => null,
                        'postal_code' => null,
                        'is_primary' => true,
                    ]);
                    $created++;
                } catch (Exception $e) {
                    $this->warn("  Failed to create address for admin ID {$admin->id}: ".$e->getMessage());
                }
            }
        }

        $this->info("  Created {$created} admin addresses.");
    }

    private function migrateOrganizationAddresses(bool $dryRun): void
    {
        $this->info('Step 5: Migrating organization addresses...');
        $orgs = Organization::with('contactUser')->get();
        $total = $orgs->count();

        if ($dryRun) {
            $this->line("  [DRY] Would create addresses for {$total} organizations");

            return;
        }

        $created = 0;
        foreach ($orgs as $org) {
            $user = $org->contactUser;
            if ($user && ($user->address || $user->barangay_id)) {
                try {
                    Address::create([
                        'addressable_type' => 'organization',
                        'addressable_id' => $org->id,
                        'block_lot_phase' => $user->address,
                        'street' => null,
                        'subdivision' => null,
                        'barangay_id' => $user->barangay_id,
                        'city' => null,
                        'province' => null,
                        'postal_code' => null,
                        'is_primary' => true,
                    ]);
                    $created++;
                } catch (Exception $e) {
                    $this->warn("  Failed to create address for org ID {$org->id}: ".$e->getMessage());
                }
            }
        }

        $this->info("  Created {$created} organization addresses.");
    }

    private function consolidatePetOwnerEmails(bool $dryRun): array
    {
        $this->info('Step 6: Consolidating pet owner emails into users table...');
        $conflicts = [];

        $petOwnerUsers = User::whereHas('roles', fn ($q) => $q->where('name', 'pet_owner'))
            ->with('petOwner')
            ->get();

        $processed = 0;
        $updated = 0;

        foreach ($petOwnerUsers as $user) {
            if ($user->petOwner && $user->petOwner->email) {
                $petOwnerEmail = $user->petOwner->email;
                if ($user->email !== $petOwnerEmail) {
                    $conflict = User::where('email', $petOwnerEmail)
                        ->where('id', '!=', $user->id)
                        ->exists();
                    if (! $conflict) {
                        if (! $dryRun) {
                            $user->update(['email' => $petOwnerEmail]);
                        }
                        $updated++;
                    } else {
                        $conflicts[] = [
                            'user_id' => $user->id,
                            'pet_owner_email' => $petOwnerEmail,
                            'conflict_with_user_ids' => User::where('email', $petOwnerEmail)->pluck('id')->toArray(),
                        ];
                    }
                }
            }
            $processed++;
        }

        $status = $dryRun ? '(DRY RUN)' : '';
        $this->info("  {$status} Processed {$processed} pet owner users, updated {$updated} emails.");

        if (! empty($conflicts) && ! $dryRun) {
            file_put_contents(
                storage_path('app/email_conflicts.json'),
                json_encode($conflicts, JSON_PRETTY_PRINT)
            );
        }

        return $conflicts;
    }
}
