<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = 0;

foreach (App\Models\Pet::whereNotNull('birthdate')->with('petInfo') as $pet) {
    // Debug: check what $pet is
    echo "Pet type: " . get_class($pet) . PHP_EOL;
    echo "Has birthdate: " . (property_exists($pet, 'birthdate') ? $pet->birthdate : 'N/A') . PHP_EOL;
    
    $age = App\Support\PetAge::compute($pet->birthdate);
    echo "Computed age: " . var_export($age, true) . PHP_EOL;
    
    if (! $pet->petInfo) {
        echo "Creating petInfo..." . PHP_EOL;
        $pet->petInfo()->create([
            'pet_id' => $pet->pet_id,
            'is_neutered' => 'no',
            'is_crossbreed' => 'no',
            'pet_age' => $age,
        ]);
    } elseif ($pet->petInfo->pet_age !== $age) {
        echo "Updating petInfo pet_age..." . PHP_EOL;
        $pet->petInfo->pet_age = $age;
        $pet->petInfo->save();
    }

    $count++;
    echo "Processed $count pets" . PHP_EOL . PHP_EOL;
}

echo "Backfilled pet_age for $count pets with valid birthdates." . PHP_EOL;