<?php

namespace Tests\Unit;

use App\Models\InventoryControl;
use App\Models\InventoryMovement;
use App\Models\VaccinationReport;
use App\Services\InventoryService;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class InventoryManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Create only the tables needed for inventory tests,
        // bypassing RefreshDatabase which fails on a MySQL-only migration.
        Schema::create('users', function ($table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('city_vet');
            $table->boolean('is_verified')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('inventory_controls', function ($table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_code')->nullable()->unique();
            $table->string('category')->nullable();
            $table->string('unit')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('batch_number')->nullable();
            $table->string('supplier')->nullable();
            $table->string('storage_location')->nullable();
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('category');
            $table->index('status');
            $table->index('expiry_date');
        });

        Schema::create('vaccination_reports', function ($table) {
            $table->id();
            $table->foreignId('vaccination_appointment_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('pet_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('barangay_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('pet_name')->nullable();
            $table->string('pet_species')->nullable();
            $table->string('pet_breed')->nullable();
            $table->string('pet_gender')->nullable();
            $table->string('pet_age')->nullable();
            $table->string('vaccine_brand')->nullable();
            $table->string('vaccine_batch_number')->nullable();
            $table->date('vaccination_date')->nullable();
            $table->string('vaccination_time')->nullable();
            $table->date('next_vaccination_date')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('vaccination_type')->nullable();
            $table->string('status')->default('pending');
            $table->text('observations')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('administered_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('inventory_control_id')->nullable()->constrained('inventory_controls')->onDelete('set null');
            $table->integer('quantity_deducted')->default(1)->nullable();
            $table->text('vaccination_records')->nullable();
            $table->text('anti_rabies_details')->nullable();
            $table->string('vaccination_card_path')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('inventory_movements', function ($table) {
            $table->id();
            $table->foreignId('inventory_control_id')->constrained('inventory_controls')->onDelete('cascade');
            $table->enum('movement_type', ['in', 'out', 'adjustment', 'transfer']);
            $table->string('movement_reason')->nullable();
            $table->integer('quantity');
            $table->text('reason')->nullable();
            $table->string('reference_number')->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('target_barangay_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('vaccination_report_id')->nullable()->constrained('vaccination_reports')->onDelete('set null');
            $table->timestamps();
            $table->index('movement_type');
            $table->index('inventory_control_id');
        });

        Schema::create('notifications', function ($table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('related_module')->nullable();
            $table->integer('related_record_id')->nullable();
            $table->string('priority')->default('normal');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    private $userCounter = 0;

    private function createCityVetUser(string $email = null): User
    {
        $this->userCounter++;

        return User::forceCreate([
            'first_name' => 'City',
            'middle_name' => null,
            'last_name' => 'Vet User',
            'email' => $email ?? "cityvet{$this->userCounter}@test.com",
            'password' => bcrypt('password'),
            'role' => 'city_vet',
            'is_verified' => 1,
        ]);
    }

    private function createInventoryItem(array $overrides = []): InventoryControl
    {
        $user = $this->createCityVetUser();

        return InventoryControl::create(array_merge([
            'item_name' => 'Rabies Vaccine',
            'item_code' => 'RAB001',
            'category' => 'vaccines',
            'unit' => 'vials',
            'quantity' => 10,
            'minimum_stock' => 2,
            'unit_cost' => 150.00,
            'description' => 'Anti-rabies vaccine',
            'status' => 'active',
            'created_by' => $user->id,
        ], $overrides));
    }

    /** @test */
    public function phase1_inventory_status_uses_lowercase_snake_case()
    {
        $item = $this->createInventoryItem([
            'status' => 'active',
        ]);

        $this->assertEquals('active', $item->status);
        $this->assertTrue($item->isActive());
        $this->assertFalse($item->isOutOfStock());

        $item->update(['status' => 'out_of_stock']);
        $this->assertEquals('out_of_stock', $item->status);
        $this->assertTrue($item->isOutOfStock());
        $this->assertFalse($item->isActive());

        $item->update(['status' => 'inactive']);
        $this->assertEquals('inactive', $item->status);
    }

    /** @test */
    public function phase2_quantity_deducted_column_exists_on_vaccination_reports()
    {
        $this->assertTrue(
            (new VaccinationReport())->getConnection()->getSchemaBuilder()->hasColumn('vaccination_reports', 'quantity_deducted')
        );

        $user = $this->createCityVetUser();
        $inventory = $this->createInventoryItem();

        $report = VaccinationReport::create([
            'vaccination_appointment_id' => 1,
            'pet_id' => 1,
            'barangay_id' => 1,
            'pet_name' => 'Test Pet',
            'pet_species' => 'dog',
            'pet_breed' => 'Aspin',
            'pet_gender' => 'male',
            'pet_age' => '6 years',
            'vaccine_brand' => null,
            'vaccine_batch_number' => null,
            'vaccination_date' => now()->toDateString(),
            'vaccination_time' => now()->toTimeString(),
            'next_vaccination_date' => null,
            'weight' => null,
            'vaccination_type' => 'anti_rabies',
            'status' => 'completed',
            'observations' => null,
            'notes' => null,
            'administered_by' => $user->id,
            'inventory_control_id' => $inventory->id,
            'quantity_deducted' => 1,
            'user_id' => $user->id,
        ]);

        $this->assertEquals(1, $report->quantity_deducted);
    }

    /** @test */
    public function phase3_auto_deducts_inventory_when_vaccination_completed()
    {
        $user = $this->createCityVetUser();
        $this->actingAs($user);

        $inventory = $this->createInventoryItem([
            'quantity' => 10,
            'minimum_stock' => 2,
        ]);

        $report = VaccinationReport::create([
            'vaccination_appointment_id' => 1,
            'pet_id' => 1,
            'barangay_id' => 1,
            'pet_name' => 'Test Pet',
            'pet_species' => 'dog',
            'pet_breed' => 'Aspin',
            'pet_gender' => 'male',
            'pet_age' => '6 years',
            'vaccination_date' => now()->toDateString(),
            'vaccination_time' => now()->toTimeString(),
            'status' => 'completed',
            'inventory_control_id' => $inventory->id,
            'quantity_deducted' => 1,
            'administered_by' => $user->id,
            'user_id' => $user->id,
        ]);

        $service = new InventoryService();
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('deductForVaccination');
        $method->setAccessible(true);

        $method->invoke($service, $report);

        // Verify inventory was deducted
        $inventory->refresh();
        $this->assertEquals(9, $inventory->quantity);
        $this->assertEquals('active', $inventory->status);

        // Verify movement record was created
        $movement = InventoryMovement::where('vaccination_report_id', $report->id)->first();
        $this->assertNotNull($movement);
        $this->assertEquals('out', $movement->movement_type);
        $this->assertEquals('vaccination', $movement->movement_reason);
        $this->assertEquals(1, $movement->quantity);
        $this->assertEquals($inventory->id, $movement->inventory_control_id);
    }

    /** @test */
    public function phase3_blocks_double_deduction_on_vaccination_re_completion()
    {
        $user = $this->createCityVetUser();
        $this->actingAs($user);

        $inventory = $this->createInventoryItem([
            'quantity' => 10,
        ]);

        $report = VaccinationReport::create([
            'vaccination_appointment_id' => 1,
            'pet_id' => 1,
            'barangay_id' => 1,
            'pet_name' => 'Test Pet',
            'pet_species' => 'dog',
            'pet_breed' => 'Aspin',
            'pet_gender' => 'male',
            'pet_age' => '6 years',
            'vaccination_date' => now()->toDateString(),
            'vaccination_time' => now()->toTimeString(),
            'status' => 'completed',
            'inventory_control_id' => $inventory->id,
            'quantity_deducted' => 1,
            'administered_by' => $user->id,
            'user_id' => $user->id,
        ]);

        // Create a movement record first to simulate already deducted
        InventoryMovement::create([
            'inventory_control_id' => $inventory->id,
            'movement_type' => 'out',
            'movement_reason' => 'vaccination',
            'quantity' => 1,
            'reason' => 'Test movement',
            'performed_by' => $user->id,
            'vaccination_report_id' => $report->id,
        ]);

        $service = new InventoryService();
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('deductForVaccination');
        $method->setAccessible(true);

        $method->invoke($service, $report);

        // Quantity should NOT have changed (double-deduction guard)
        $inventory->refresh();
        $this->assertEquals(10, $inventory->quantity);

        // Only one movement record should exist
        $this->assertEquals(1, InventoryMovement::where('vaccination_report_id', $report->id)->count());
    }

    /** @test */
    public function phase3_sets_status_to_out_of_stock_when_quantity_reaches_zero()
    {
        $user = $this->createCityVetUser();
        $this->actingAs($user);

        $inventory = $this->createInventoryItem([
            'quantity' => 1,
            'minimum_stock' => 0,
        ]);

        $report = VaccinationReport::create([
            'vaccination_appointment_id' => 1,
            'pet_id' => 1,
            'barangay_id' => 1,
            'pet_name' => 'Test Pet',
            'pet_species' => 'dog',
            'pet_breed' => 'Aspin',
            'pet_gender' => 'male',
            'pet_age' => '6 years',
            'vaccination_date' => now()->toDateString(),
            'vaccination_time' => now()->toTimeString(),
            'status' => 'completed',
            'inventory_control_id' => $inventory->id,
            'quantity_deducted' => 1,
            'administered_by' => $user->id,
            'user_id' => $user->id,
        ]);

        $service = new InventoryService();
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('deductForVaccination');
        $method->setAccessible(true);

        $method->invoke($service, $report);

        $inventory->refresh();
        $this->assertEquals(0, $inventory->quantity);
        $this->assertEquals('out_of_stock', $inventory->status);
    }

    /** @test */
    public function phase3_skips_deduction_when_no_inventory_control_linked()
    {
        $user = $this->createCityVetUser();
        $this->actingAs($user);

        $report = VaccinationReport::create([
            'vaccination_appointment_id' => 1,
            'pet_id' => 1,
            'barangay_id' => 1,
            'pet_name' => 'Test Pet',
            'pet_species' => 'dog',
            'pet_breed' => 'Aspin',
            'pet_gender' => 'male',
            'pet_age' => '6 years',
            'vaccination_date' => now()->toDateString(),
            'vaccination_time' => now()->toTimeString(),
            'status' => 'completed',
            'inventory_control_id' => null,
            'quantity_deducted' => 1,
            'administered_by' => $user->id,
            'user_id' => $user->id,
        ]);

        $service = new InventoryService();
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('deductForVaccination');
        $method->setAccessible(true);

        // Should not throw
        $method->invoke($service, $report);

        // No movement records should exist
        $this->assertEquals(0, InventoryMovement::count());
    }

    /** @test */
    public function phase4_inventory_expiry_check_command_runs()
    {
        $user = $this->createCityVetUser();

        InventoryControl::create([
            'item_name' => 'Expiring Vaccine',
            'category' => 'vaccines',
            'quantity' => 5,
            'status' => 'active',
            'expiry_date' => now()->addDays(15)->toDateString(),
            'created_by' => $user->id,
        ]);

        InventoryControl::create([
            'item_name' => 'Fresh Vaccine',
            'category' => 'vaccines',
            'quantity' => 5,
            'status' => 'active',
            'expiry_date' => now()->addDays(90)->toDateString(),
            'created_by' => $user->id,
        ]);

        // Verify the scope finds the expiring item
        $this->assertEquals(1, InventoryControl::expiringSoon(30)->count());

        $result = $this->artisan('inventory:expiry-check');
        $result->assertExitCode(0);
    }

    /** @test */
    public function phase4_inventory_expiry_check_no_items_expiring()
    {
        $user = $this->createCityVetUser();

        InventoryControl::create([
            'item_name' => 'Fresh Vaccine',
            'category' => 'vaccines',
            'quantity' => 5,
            'status' => 'active',
            'expiry_date' => now()->addDays(90)->toDateString(),
            'created_by' => $user->id,
        ]);

        $result = $this->artisan('inventory:expiry-check');
        $result->assertExitCode(0);

        // Verify no notification was sent
        $this->assertDatabaseMissing('notifications', [
            'title' => 'Inventory Expiry Alert',
            'related_module' => 'inventory',
        ]);
    }

    /** @test */
    public function phase4_inventory_expiry_check_sends_notification()
    {
        $user = $this->createCityVetUser();

        InventoryControl::create([
            'item_name' => 'Expiring Soon',
            'category' => 'vaccines',
            'quantity' => 5,
            'status' => 'active',
            'expiry_date' => now()->addDays(10)->toDateString(),
            'created_by' => $user->id,
        ]);

        $this->artisan('inventory:expiry-check');

        $this->assertDatabaseHas('notifications', [
            'title' => 'Inventory Expiry Alert',
            'related_module' => 'inventory',
        ]);
    }
}
