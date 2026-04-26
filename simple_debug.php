<?php

use App\Models\PetOwner;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Foundation\Application;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
/** @var Application $app */
$app->make(Kernel::class)->bootstrap();

echo "=== SIMPLE DEBUG: Checking PetOwner table ===\n\n";

// Let's try to insert a record with explicit NULL for phone_number to see what happens
try {
    $user = User::create([
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test'.time().'@example.com',
        'password' => bcrypt('secret'),
        'status' => 'active',
    ]);

    echo "✓ User created: ID {$user->id}\n";

    // Try to insert pet owner with explicit NULL for phone_number
    $petOwner = DB::table('pet_owners')->insertGetId([
        'user_id' => $user->id,
        'first_name' => 'Test',
        'last_name' => 'User',
        'phone_number' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    echo "✓ Pet owner inserted via DB facade: ID {$petOwner}\n";

    // Now let's check what columns exist
    $columns = Schema::getColumnListing('pet_owners');
    echo "Pet owner columns:\n";
    foreach ($columns as $column) {
        echo "  - {$column}\n";
    }

    // Clean up
    DB::table('pet_owners')->where('owner_id', $petOwner)->delete();
    $user->delete();

} catch (Exception $e) {
    echo '✗ Error: '.$e->getMessage()."\n";
    if ($e->getPrevious()) {
        echo '  Previous: '.$e->getPrevious()->getMessage()."\n";
    }
}

// Let's also check what the model's fillable actually contains
echo "\n=== MODEL FILLABLE CHECK ===\n";
$model = new PetOwner;
$reflection = new ReflectionObject($model);
$properties = [];
foreach ($reflection->getProperties() as $property) {
    if ($property->isPublic() || $property->isProtected()) {
        $property->setAccessible(true);
        $properties[$property->getName()] = $property->getValue($model);
    }
}

echo "PetOwner properties:\n";
foreach ($properties as $name => $value) {
    echo "  {$name}: ".var_export($value, true)."\n";
}

// Specifically check fillable
if (isset($properties['fillable'])) {
    echo "\nFillable fields:\n";
    foreach ($properties['fillable'] as $field) {
        echo "  - {$field}\n";
    }
}
