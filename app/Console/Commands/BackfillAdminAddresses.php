<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Barangay;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillAdminAddresses extends Command
{
    protected $signature = 'addresses:backfill-admins
                            {--dry-run : Preview changes without saving}
                            {--force : Skip confirmation prompt}';

    protected $description = 'Backfill addresses for existing admin accounts that lack address data';

    private array $rawRecords = [
        [
            'admin_id' => 1,
            'block_lot_phase' => 'Blk 12 Lot 05 Ph 1',
            'street' => 'Mabini St.',
            'subdivision' => 'Greenwoods Subdivision',
            'barangay_id' => 12,
            'city' => 'Dasmariñas',
            'province' => 'Cavite',
            'postal_code' => '4114',
        ],
        [
            'admin_id' => 2,
            'block_lot_phase' => 'Blk 08 Lot 19 Ph 2',
            'street' => 'Rizal Ave.',
            'subdivision' => 'Golden City',
            'barangay_id' => 25,
            'city' => 'Dasmariñas',
            'province' => 'Cavite',
            'postal_code' => '4114',
        ],
        [
            'admin_id' => 4,
            'block_lot_phase' => 'Blk 21 Lot 48 Ph 1',
            'street' => 'Luna St.',
            'subdivision' => 'Palapala Homes',
            'barangay_id' => 41,
            'city' => 'Dasmariñas',
            'province' => 'Cavite',
            'postal_code' => '4114',
        ],
        [
            'admin_id' => 6,
            'block_lot_phase' => 'Blk 03 Lot 33 Ph 3',
            'street' => 'Bonifacio St.',
            'subdivision' => 'Salawag Village',
            'barangay_id' => 58,
            'city' => 'Dasmariñas',
            'province' => 'Cavite',
            'postal_code' => '4114',
        ],
        [
            'admin_id' => 8,
            'block_lot_phase' => 'Blk 15 Lot 12 Ph 2',
            'street' => 'Del Pilar St.',
            'subdivision' => 'Orchard Estate',
            'barangay_id' => 67,
            'city' => 'Dasmariñas',
            'province' => 'Cavite',
            'postal_code' => '4114',
        ],
    ];

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        if (! $dryRun && ! $force) {
            $this->warn('This will modify your database. Use --dry-run to preview or --force to skip confirmation.');
            if (! $this->confirm('Do you want to continue?')) {
                $this->info('Backfill cancelled.');

                return Command::SUCCESS;
            }
        }

        if ($dryRun) {
            $this->info('[DRY RUN] No changes will be saved.');
        }

        $this->info('Starting admin address backfill...');

        $barangayCache = [];
        $created = 0;
        $skipped = 0;
        $warnings = 0;

        try {
            DB::beginTransaction();

            foreach ($this->rawRecords as $record) {
                $adminId = $record['admin_id'];

                $admin = Admin::find($adminId);
                if (! $admin) {
                    $this->error("  Admin ID {$adminId} not found. Skipping.");
                    $skipped++;
                    continue;
                }

                $existing = Address::where('addressable_type', 'admin')
                    ->where('addressable_id', $adminId)
                    ->exists();

                if ($existing) {
                    $this->warn("  Admin ID {$adminId} already has an address. Skipping.");
                    $warnings++;
                    continue;
                }

                $barangayId = $record['barangay_id'];
                if ($barangayId !== null && $barangayId !== '') {
                    $key = (int) $barangayId;
                    if (! isset($barangayCache[$key])) {
                        $exists = Barangay::where('barangay_id', $key)->exists();
                        $barangayCache[$key] = $exists ? $key : null;
                    }
                    $barangayId = $barangayCache[$key];
                    if ($barangayId === null) {
                        $this->warn("  Barangay ID {$record['barangay_id']} not found for admin {$adminId}. Setting barangay_id to NULL.");
                        $warnings++;
                    }
                }

                $addressData = [
                    'addressable_type' => 'admin',
                    'addressable_id' => $adminId,
                    'block_lot_phase' => $record['block_lot_phase'] ?? null,
                    'street' => $record['street'] ?? null,
                    'subdivision' => $record['subdivision'] ?? null,
                    'barangay_id' => $barangayId,
                    'city' => $record['city'] ?? null,
                    'province' => $record['province'] ?? null,
                    'postal_code' => $record['postal_code'] ?? null,
                    'is_primary' => true,
                ];

                if ($dryRun) {
                    $this->line("  [DRY] Would create address for admin ID {$adminId}: {$addressData['street']}, {$addressData['city']}");
                } else {
                    Address::create($addressData);
                    $this->line("  Created address for admin ID {$adminId}: {$addressData['street']}, {$addressData['city']}");
                }

                $created++;
            }

            if (! $dryRun) {
                DB::commit();
            }

            $this->info('');
            $this->info('Backfill summary:');
            $this->line("  Created: {$created}");
            $this->line("  Skipped: {$skipped}");
            $this->line("  Warnings: {$warnings}");

            if ($dryRun) {
                $this->info('[DRY RUN] completed. No changes committed.');
            } else {
                $this->info('✅ Backfill completed successfully!');
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Backfill failed: '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
