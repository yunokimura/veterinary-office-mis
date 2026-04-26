<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
/** @var Application $app */
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

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

// Create a mock request
use App\Http\Controllers\Clients\Auth\RegisteredUserController;
use App\Models\Address;
use App\Models\PetOwner;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

$request = Request::create('/register', 'POST', $testData);

// Get the controller
$controller = new RegisteredUserController;

// Since we can't easily call the protected method directly,
// let's test the core functionality by checking what happens when we create a user

// First, let's check if we can create a basic user and pet owner
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

    // Now test our address creation function by accessing it via reflection
    $reflection = new ReflectionMethod($controller, 'createPetOwnerAddress');
    $reflection->setAccessible(true);

    // Create a request with test address data
    $addrRequest = Request::create('/', 'POST', [
        'block_lot_phase_house_no_1' => '123',
        'block_lot_phase_house_no_2' => '456',
        'block_lot_phase_house_no_3' => '7A',
        'block_lot_phase_house_no_4' => '890',
        'street_name' => 'Test Street',
        'subdivision' => 'Test Subdivision',
        'barangay' => 'Burol I',
    ]);

    // Call the method
    $reflection->invoke($controller, $addrRequest, $petOwner);

    // Refresh the pet owner from database
    $petOwner->refresh();

    echo "✓ After address creation:\n";
    echo '  address_id: '.($petOwner->address_id ?? 'NULL')."\n";

    if ($petOwner->address_id) {
        $address = Address::find($petOwner->address_id);
        if ($address) {
            echo "  Address record found:\n";
            echo "    ID: {$address->id}\n";
            echo "    Type: {$address->addressable_type}\n";
            echo "    Owner ID: {$address->addressable_id}\n";
            echo "    Block/Lot/Phase: {$address->block_lot_phase}\n";
            echo "    Street: {$address->street}\n";
            echo "    Subdivision: {$address->subdivision}\n";
            echo "    Barangay ID: {$address->barangay_id}\n";

            if ($address->barangay) {
                echo "    Barangay: {$address->barangay->barangay_name}\n";
                echo "    City: {$address->barangay->city}\n";
                echo "    Province: {$address->barangay->province}\n";
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
