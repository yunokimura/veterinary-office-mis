<?php

namespace App\Console\Commands;

use App\Models\VaccinationAppointment;
use App\Models\VaccinationReport;
use App\Models\Pet;
use App\Models\PetOwner;
use App\Models\User;
use App\Models\Address;
use App\Models\InventoryControl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportRealVaccinationData extends Command
{
    protected $signature = 'import:real-vaccination-data 
                            {--owners=6,8 : Comma-separated owner IDs to use}
                            {--inventory= : Inventory CSV path}
                            {--dry-run : Show what would be created without inserting}';

    protected $description = 'Import real vaccination data for owners 6 and 8 with their pets';

    public function handle(): int
    {
        $ownerIds = array_map('intval', explode(',', $this->option('owners')));
        $inventoryCsv = $this->option('inventory') ?? 'C:/Users/Admin/Downloads/inventory_15.csv';
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN - no data will be inserted');
        }

        // Step 1: Import inventory
        $this->info('Step 1: Importing inventory...');
        $inventoryMap = $this->importInventory($inventoryCsv, $dryRun);

        if (empty($inventoryMap)) {
            $this->error('No inventory items found or imported.');
            return 1;
        }

        $this->info('Imported ' . count($inventoryMap) . ' inventory items.');

        // Step 2: Process owners and create appointments
        $this->info('Step 2: Creating appointments for owners...');
        
        foreach ($ownerIds as $ownerId) {
            $this->processOwner($ownerId, $inventoryMap, $dryRun);
        }

        $this->info('Done!');
        return 0;
    }

    private function importInventory(string $csvPath, bool $dryRun): array
    {
        if (!file_exists($csvPath)) {
            $this->error("Inventory CSV not found: $csvPath");
            return [];
        }

        $handle = fopen($csvPath, 'r');
        if (!$handle) {
            $this->error("Could not open inventory CSV: $csvPath");
            return [];
        }

        $header = fgetcsv($handle);
        $map = [];
        $rowNum = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            $data = array_combine($header, $row);
            
            if (!$data || empty($data['item_code'])) {
                continue;
            }

            $itemCode = $data['item_code'];
            $itemName = $data['item_name'];

            if ($dryRun) {
                $this->line("  [DRY RUN] Would import: {$itemName} ({$itemCode})");
                $map[$itemCode] = $itemName . '_' . $itemCode;
                continue;
            }

            // Check if already exists
            $existing = InventoryControl::where('item_code', $itemCode)->first();
            if ($existing) {
                $this->line("  [SKIP] {$itemName} ({$itemCode}) already exists with ID {$existing->id}");
                $map[$itemCode] = $existing->id;
                continue;
            }

            $record = InventoryControl::create([
                'item_name' => $data['item_name'],
                'item_code' => $data['item_code'],
                'category' => $data['category'] ?? 'Other',
                'unit' => $data['unit'] ?? 'piece',
                'quantity' => (int)($data['quantity'] ?? 0),
                'minimum_stock' => (int)($data['minimum_stock'] ?? 0),
                'unit_cost' => (float)($data['unit_cost'] ?? 0),
                'description' => $data['description'] ?? null,
                'expiry_date' => !empty($data['expiry_date']) ? $data['expiry_date'] : null,
                'batch_number' => $data['batch_number'] ?? null,
                'supplier' => $data['supplier'] ?? null,
                'storage_location' => $data['storage_location'] ?? null,
                'status' => $data['status'] ?? 'Active',
                'created_by' => !empty($data['created_by']) ? (int)$data['created_by'] : null,
                'created_at' => !empty($data['created_at']) ? $data['created_at'] : now(),
                'updated_at' => !empty($data['updated_at']) ? $data['updated_at'] : now(),
            ]);

            $map[$itemCode] = $record->id;
            $this->line("  [IMPORTED] {$itemName} ({$itemCode}) -> ID {$record->id}");
        }

        fclose($handle);
        return $map;
    }

    private function processOwner(int $ownerId, array $inventoryMap, bool $dryRun): void
    {
        $owner = PetOwner::where('owner_id', $ownerId)->first();
        if (!$owner) {
            $this->warn("Owner ID {$ownerId} not found.");
            return;
        }

        $user = User::whereHas('petOwner', function ($q) use ($ownerId) {
            $q->where('owner_id', $ownerId);
        })->first();

        $address = Address::where('addressable_id', $ownerId)
            ->where('addressable_type', 'pet_owner')
            ->first();

        $pets = Pet::where('owner_id', $ownerId)->get();
        if ($pets->isEmpty()) {
            $this->warn("Owner {$ownerId} ({$owner->first_name} {$owner->last_name}) has no pets.");
            return;
        }

        $this->line("Processing owner: {$owner->first_name} {$owner->last_name} (ID: {$ownerId})");
        $this->line("  Pets found: " . $pets->count());

        foreach ($pets as $pet) {
            $this->createAppointmentForPet($owner, $user, $address, $pet, $inventoryMap, $dryRun);
        }
    }

    private function createAppointmentForPet(PetOwner $owner, ?User $user, ?Address $address, Pet $pet, array $inventoryMap, bool $dryRun): void
    {
        $scheduledAt = now()->addDays(rand(1, 30))->setHour(rand(8, 15))->setMinute([0, 15, 30, 45][rand(0, 3)]);

        $metadata = [
            'service' => 'Anti-Rabies Vaccination',
            'dose' => rand(0, 1) ? '1st Dose' : 'Booster',
            'selected_pets' => [
                [
                    'id' => $pet->pet_id,
                    'name' => $pet->pet_name,
                    'species' => $pet->species,
                ]
            ]
        ];

        if ($dryRun) {
            $this->line("  [DRY RUN] Would create appointment for {$pet->pet_name} (Pet ID: {$pet->pet_id})");
            return;
        }

        $appointment = VaccinationAppointment::create([
            'user_id' => $user?->id,
            'owner_id' => $owner->owner_id,
            'address_id' => $address?->id,
            'scheduled_at' => $scheduledAt,
            'status' => 'completed',
            'metadata' => $metadata,
            'last_anti_rabies_date' => now()->subYear()->toDateString(),
            'recent_surgery' => false,
        ]);

        $this->line("  [CREATED] Appointment ID {$appointment->id} for {$pet->pet_name} (Pet ID: {$pet->pet_id})");

        // Create vaccination report
        $barangay = $address->barangay ?? null;
        $inventoryItem = InventoryControl::inRandomOrder()->first();

        $report = VaccinationReport::create([
            'vaccination_appointment_id' => $appointment->id,
            'pet_id' => $pet->pet_id,
            'barangay_id' => $barangay?->barangay_id,
            'pet_name' => $pet->pet_name,
            'pet_species' => $pet->species,
            'pet_breed' => $pet->breed,
            'pet_gender' => $pet->gender,
            'pet_age' => $pet->age,
            'vaccine_brand' => $inventoryItem?->item_name ?? 'Rabies Vaccine',
            'vaccine_batch_number' => $inventoryItem?->batch_number ?? 'RB2026-001',
            'vaccination_date' => $appointment->scheduled_at->toDateString(),
            'vaccination_time' => $appointment->scheduled_at->toTimeString(),
            'next_vaccination_date' => $appointment->scheduled_at->addYear()->toDateString(),
            'weight' => rand(2, 30) + rand(0, 99) / 100,
            'vaccination_type' => 'Anti-Rabies',
            'status' => 'completed',
            'observations' => 'Routine vaccination; no adverse reaction.',
            'notes' => null,
            'administered_by' => $user?->id ?? 1,
            'inventory_control_id' => $inventoryItem?->id,
        ]);

        $this->line("  [CREATED] Report ID {$report->id} for {$pet->pet_name}");
    }
}
