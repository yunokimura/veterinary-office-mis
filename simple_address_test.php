<?php

use App\Models\Address;
use App\Models\Barangay;
use App\Models\PetOwner;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Foundation\Application;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
/** @var Application $app */
$app->make(Kernel::class)->bootstrap();

// Test data
$testData = [
    'name' => 'Test User',
    'email' => 'test'.time().'@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'block_lot_phase_house_no_1' => '123',
    'block_lot_phase_house_no_2' => '456',
    'block_lot_phase_house_no_3' => '7A',
    'block_lot_phase_house_no_4' => '890',
    'street_name' => 'Test Street',
    'subdivision' => 'Test Subdivision',
    'barangay' => 'Burol I', // Using a real barangay from the form
    'terms' => 'on',
];

echo "Testing address registration...\n";
echo 'Test data: '.json_encode($testData)."\n\n";

// Test the core functionality
try {
    // Create user
    $user = User::create([
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test2'.time().'@example.com',
        'password' => bcrypt('password123'),
        'status' => 'active',
    ]);

    echo "✓ User created with ID: {$user->id}\n";

    // Create pet owner
    $petOwner = PetOwner::create([
        'user_id' => $user->id,
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test2'.time().'@example.com',
    ]);

    echo "✓ Pet owner created with ID: {$petOwner->owner_id}\n";
    echo '  Initial address_id: '.($petOwner->address_id ?? 'NULL')."\n";

    // Test address creation logic directly
    // Combine block/lot/phase/house number fields
    $blockLotPhase = trim(
        implode('-', array_filter([
            $testData['block_lot_phase_house_no_1'],
            $testData['block_lot_phase_house_no_2'],
            $testData['block_lot_phase_house_no_3'],
            $testData['block_lot_phase_house_no_4'],
        ]))
    );
    if ($blockLotPhase === '') {
        $blockLotPhase = null;
    }

    echo '  Combined block/lot/phase: '.var_export($blockLotPhase, true)."\n";

    // Look up barangay ID
    $barangayName = $testData['barangay'];
    $barangay = Barangay::where('barangay_name', $barangayName)->first();

    // If barangay not found, use first available barangay as fallback
    if (! $barangay) {
        $barangay = Barangay::first();
        echo "  Barangay not found, using fallback\n";
    }

    if ($barangay) {
        echo "  Using barangay: {$barangay->barangay_name} (ID: {$barangay->barangay_id})\n";
    } else {
        echo "  No barangay found at all!\n";
    }

    // Create address record
    $address = Address::create([
        'addressable_type' => PetOwner::class,
        'addressable_id' => $petOwner->owner_id,
        'block_lot_phase' => $blockLotPhase,
        'street' => $testData['street_name'],
        'subdivision' => $testData['subdivision'],
        'barangay_id' => $barangay ? $barangay->barangay_id : null,
        'postal_code' => null, // Using null as postal code is optional
        'is_primary' => true,
    ]);

    echo "✓ Address created with ID: {$address->id}\n";

    // Update pet owner with address_id
    $petOwner->update([
        'address_id' => $address->id,
    ]);

    // Refresh the pet owner from database
    $petOwner->refresh();

    echo "✓ After address linking:\n";
    echo '  Pet owner address_id: '.($petOwner->address_id ?? 'NULL')."\n";

    if ($petOwner->address_id) {
        $addressCheck = Address::find($petOwner->address_id);
        if ($addressCheck) {
            echo "  Address record verified:\n";
            echo "    ID: {$addressCheck->id}\n";
            echo "    Type: {$addressCheck->addressable_type}\n";
            echo "    Owner ID: {$addressCheck->addressable_id}\n";
            echo "    Block/Lot/Phase: {$addressCheck->block_lot_phase}\n";
            echo "    Street: {$addressCheck->street}\n";
            echo "    Subdivision: {$addressCheck->subdivision}\n";
            echo "    Barangay ID: {$addressCheck->barangay_id}\n";

            if ($addressCheck->barangay) {
                echo "    Barangay: {$addressCheck->barangay->barangay_name}\n";
                echo "    City: {$addressCheck->barangay->city}\n";
                echo "    Province: {$addressCheck->barangay->province}\n";
            }

            echo "  ✓ Address linking successful!\n";
        } else {
            echo "  ✗ Address record NOT found for ID: {$petOwner->address_id}\n";
        }
    } else {
        echo "  ✗ address_id is still NULL after address creation\n";
    }

    // Clean up test data
    if (isset($address)) {
        $address->delete();
    }
    $petOwner->delete();
    $user->delete();

    echo "\n✓ Test cleanup completed\n";

} catch (Exception $e) {
    echo '✗ Error during test: '.$e->getMessage()."\n";
    echo $e->getTraceAsString();
}
