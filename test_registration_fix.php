<?php

use App\Http\Controllers\Clients\Auth\RegisteredUserController;
use App\Models\Address;
use App\Models\PetOwner;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
/** @var Application $app */
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING REGISTRATION FIX ===\n\n";

// Test data mimicking the registration form
$testData = [
    'name' => 'Chelsy Joy', // The user mentioned in the issue
    'email' => 'chelsey.joy.'.time().'@example.com',
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
    // Import the controller to access the method
    $controller = new RegisteredUserController;

    // Create a request object with the test data
    $request = Request::create('/register', 'POST', $testData);

    // Call the address creation method
    $controller->createPetOwnerAddress($request, $petOwner);

    // Refresh the pet owner from database
    $petOwner->refresh();

    echo "✓ STEP 3 - Address created and linked:\n";
    echo '  PetOwner address_id: '.($petOwner->address_id ?? 'NULL')."\n\n";

    // VERIFICATION
    echo "=== VERIFICATION RESULTS ===\n";

    // Check 1: PetOwner address_id is not null
    if ($petOwner->address_id !== null) {
        echo "✓ PASS: PetOwner.address_id is NOT null\n";
        echo "  Address ID: {$petOwner->address_id}\n";
    } else {
        echo "✗ FAIL: PetOwner.address_id is still null\n";
    }

    // Check 2: Address record exists
    if ($petOwner->address_id) {
        $address = Address::find($petOwner->address_id);
        if ($address) {
            echo "✓ PASS: Address record found\n";
            echo "  Address ID: {$address->id}\n";
            echo "  Type: {$address->addressable_type}\n";
            echo "  Owner ID: {$address->addressable_id}\n";
            echo "  Block/Lot/Phase: {$address->block_lot_phase}\n";
            echo "  Street: {$address->street}\n";
            echo "  Subdivision: {$address->subdivision}\n";
            echo "  Barangay ID: {$address->barangay_id}\n";

            if ($address->barangay) {
                echo "  Barangay: {$address->barangay->barangay_name}\n";
                echo "  City: {$address->barangay->city}\n";
                echo "  Province: {$address->barangay->province}\n";
            }
        } else {
            echo "✗ FAIL: Address record NOT found for ID: {$petOwner->address_id}\n";
        }
    } else {
        echo "✗ FAIL: No address_id to check\n";
    }

    // Check 3: Relationship works
    try {
        $relatedAddress = $petOwner->address;
        if ($relatedAddress && $relatedAddress->id === $petOwner->address_id) {
            echo "✓ PASS: PetOwner->address relationship works correctly\n";
        } else {
            echo "✗ FAIL: PetOwner->address relationship broken\n";
        }
    } catch (Exception $e) {
        echo '✗ FAIL: Error accessing PetOwner->address relationship: '.$e->getMessage()."\n";
    }

    echo "\n";

    // Clean up test data
    if (isset($address)) {
        $address->delete();
    }
    $petOwner->delete();
    $user->delete();

    echo "✓ Test cleanup completed\n";

    // Final result
    $success =
        ($petOwner->address_id !== null) &&
        isset($address) &&
        $address->id === $petOwner->address_id;

    if ($success) {
        echo "🎉 OVERALL RESULT: SUCCESS! The fix is working correctly.\n";
        echo "   When users like Chelsy Joy register, their address_id will no longer be null.\n";
    } else {
        echo "❌ OVERALL RESULT: FAILURE! The fix needs more work.\n";
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
        if (isset($address)) {
            $address->delete();
        }
    } catch (Exception $cleanupError) {
        // Ignore cleanup errors
    }
}
