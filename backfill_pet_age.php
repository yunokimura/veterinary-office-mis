<?php

use App\Models\Pet;
use App\Support\PetAge;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = 0;

$pets = Pet::whereNotNull('birthdate')->get();

foreach ($pets as $pet) {
    $age = PetAge::compute($pet->birthdate);

    if (! $pet->petInfo) {
        $pet->petInfo()->create([
            'pet_id' => $pet->pet_id,
            'is_neutered' => 'no',
            'is_crossbreed' => 'no',
            'pet_age' => $age,
        ]);
    } elseif ($pet->petInfo->pet_age !== $age) {
        $pet->petInfo->pet_age = $age;
        $pet->petInfo->save();
    }

    $count++;
}

echo "Backfilled pet_age for {$count} pets with valid birthdates. PHP_EOL";