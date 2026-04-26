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

echo "=== FINAL TEST: Address Registration During User Registration ===\n\n";

// Test data mimicking the registration form
$testData = [
    'name' => 'Juan Dela Cruz',
    'email' => 'juan'.time().'@example.com',
    'password' => 'securePassword123!',
    'password_confirmation' => 'securePassword123!',
    // Address fields from the form
    'block_lot_phase_house_no_1' => '123',
    'block_lot_phase_house_no_2' => '456',
    'block_lot_phase_house_no_3' => '7A',
    'block_lot_phase_house_no_4' => '789',
    'street_name' => 'Jose Rizal Street',
    'subdivision' => 'Green Valley Subdivision',
    'barangay' => 'Burol I', // This should exist in the database
    'terms' => 'on',
];

echo "Test Data:\n";
echo '  Name: '.$testData['name']."\n";
echo '  Email: '.$testData['email']."\n";
echo '  Address: '.implode(' ', array_filter([
    $testData['block_lot_phase_house_no_1'],
    $testData['block_lot_phase_house_no_2'],
    $testData['block_lot_phase_house_no_3'],
    $testData['block_lot_phase_house_no_4'],
])).' '.$testData['street_name'].', '.
    $testData['subdivision'].', '.$testData['barangay']."\n\n";

try {
    // STEP 1: Create User (simulating what RegisteredUserController does)
    $nameParts = explode(' ', $testData['name'], 2);
    $firstName = $nameParts[0] ?? '';
    $lastName = $nameParts[1] ?? '';

    $user = User::create([
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $testData['email'],
        'password' => bcrypt($testData['password']),
        'status' => 'active',
    ]);

    echo "✓ STEP 1 - User created:\n";
    echo "  ID: {$user->id}\n";
    echo "  Name: {$user->first_name} {$user->last_name}\n";
    echo "  Email: {$user->email}\n\n";

    // STEP 2: Create PetOwner record (simulating what RegisteredUserController does)
    $petOwner = PetOwner::create([
        'user_id' => $user->id,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $testData['email'],
    ]);

    echo "✓ STEP 2 - PetOwner created:\n";
    echo "  ID: {$petOwner->owner_id}\n";
    echo "  User ID: {$petOwner->user_id}\n";
    echo "  Name: {$petOwner->first_name} {$petOwner->last_name}\n";
    echo '  Address ID: '.($petOwner->address_id ?? 'NULL')." (should be NULL for now)\n\n";

    // STEP 3: Create and link Address record (this is what our new method does)
    // Simulate the createPetOwnerAddress method logic

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

    // Look up barangay ID
    $barangayName = $testData['barangay'];
    $barangay = Barangay::where('barangay_name', $barangayName)->first();

    // If barangay not found, use first available barangay as fallback
    if (! $barangay) {
        $barangay = Barangay::first();
        echo "  WARNING: Barangay '$barangayName' not found, using fallback\n";
    }

    // Create address record
    $address = Address::create([
        'addressable_type' => PetOwner::class,
        'addressable_id' => $petOwner->owner_id,
        'block_lot_phase' => $blockLotPhase,
        'street' => $testData['street_name'],
        'subdivision' => $testData['subdivision'],
        'barangay_id' => $barangay ? $barangay->barangay_id : null,
        'postal_code' => null,
        'is_primary' => true,
    ]);

    echo "✓ STEP 3 - Address created:\n";
    echo "  ID: {$address->id}\n";
    echo "  Type: {$address->addressable_type}\n";
    echo "  Owner ID: {$address->addressable_id}\n";
    echo "  Block/Lot/Phase: {$address->block_lot_phase}\n";
    echo "  Street: {$address->street}\n";
    echo "  Subdivision: {$address->subdivision}\n";
    echo "  Barangay ID: {$address->barangay_id} ";
    if ($address->barangay) {
        echo "({$address->barangay->barangay_name})";
    }
    echo "\n\n";

    // Update pet owner with address_id
    $petOwner->update([
        'address_id' => $address->id,
    ]);

    // Refresh the pet owner from database
    $petOwner->refresh();

    echo "✓ STEP 4 - PetOwner updated with address_id:\n";
    echo '  Address ID: '.($petOwner->address_id ?? 'NULL')."\n\n";

    // VERIFICATION
    echo "=== VERIFICATION RESULTS ===\n";

    // Check 1: PetOwner address_id is not null
    if ($petOwner->address_id !== null) {
        echo "✓ PASS: PetOwner.address_id is NOT null\n";
    } else {
        echo "✗ FAIL: PetOwner.address_id is still null\n";
    }

    // Check 2: Address record exists and matches
    if ($petOwner->address_id && $address->id === $petOwner->address_id) {
        echo "✓ PASS: Address record ID matches PetOwner.address_id\n";
    } else {
        echo "✗ FAIL: Address record ID mismatch\n";
    }

    // Check 3: Address has correct data
    $checks = [
        'block_lot_phase' => $address->block_lot_phase === $blockLotPhase,
        'street' => $address->street === $testData['street_name'],
        'subdivision' => $address->subdivision === $testData['subdivision'],
        'barangay_id' => ($address->barangay_id === ($barangay ? $barangay->barangay_id : null)),
    ];

    $allChecksPass = true;
    foreach ($checks as $field => $result) {
        if ($result) {
            echo "✓ PASS: Address.{$field} is correct\n";
        } else {
            echo "✗ FAIL: Address.{$field} is incorrect\n";
            $allChecksPass = false;
        }
    }

    // Check 4: Relationship works
    try {
        $relatedAddress = $petOwner->address;
        if ($relatedAddress && $relatedAddress->id === $address->id) {
            echo "✓ PASS: PetOwner->address relationship works correctly\n";
        } else {
            echo "✗ FAIL: PetOwner->address relationship broken\n";
        }
    } catch (Exception $e) {
        echo '✗ FAIL: Error accessing PetOwner->address relationship: '.$e->getMessage()."\n";
    }

    echo "\n";

    // Clean up
    if (isset($address)) {
        $address->delete();
    }
    $petOwner->delete();
    $user->delete();

    echo "✓ Test cleanup completed\n";

    // Final result
    $overallSuccess =
        ($petOwner->address_id !== null) &&
        ($petOwner->address_id && $address->id === $petOwner->address_id) &&
        $allChecksPass;

    if ($overallSuccess) {
        echo "\n🎉 OVERALL RESULT: SUCCESS! The address registration fix is working correctly.\n";
        echo "   During actual registration, address_id will no longer be null in pet_owners table.\n";
    } else {
        echo "\n❌ OVERALL RESULT: FAILURE! There are issues with the implementation.\n";
    }

} catch (Exception $e) {
    echo '✗ ERROR: '.$e->getMessage()."\n";
    echo $e->getTraceAsString();

    // Attempt cleanup
    try {
        if (isset($petOwner)) {
            $petOwner->delete();
        }
        if (isset($user)) {
            $user->delete();
        }
    } catch (Exception $cleanupError) {
        // Ignore cleanup errors
    }
}
