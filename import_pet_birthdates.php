<?php

use App\Models\Pet;
use App\Models\PetInfo;
use App\Support\PetAge;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$csvPath = 'C:/Users/Admin/Desktop/pet_birthdate.csv';

if (!file_exists($csvPath)) {
    echo "CSV file not found: {$csvPath}\n";
    exit(1);
}

$csv = array_map('str_getcsv', file($csvPath));
array_shift($csv); // Remove header

$count = 0;
$errors = [];

foreach ($csv as $row) {
    if (count($row) < 2) {
        continue;
    }

    $petId = (int) $row[0];
    $birthdate = $row[1];

    if ($petId <= 0 || empty($birthdate)) {
        $errors[] = "Invalid row: " . implode(',', $row);
        continue;
    }

    $pet = Pet::find($petId);
    if (!$pet) {
        $errors[] = "Pet ID {$petId} not found";
        continue;
    }

    $computedAge = PetAge::compute($birthdate);

    $pet->birthdate = $birthdate;
    $pet->save();

    $petInfo = PetInfo::where('pet_id', $petId)->first();
    if ($petInfo) {
        $petInfo->pet_age = $computedAge;
        $petInfo->save();
    } else {
        PetInfo::create([
            'pet_id' => $petId,
            'pet_age' => $computedAge,
        ]);
    }

    $count++;
}

echo "Updated {$count} pets with birthdate and computed pet_age.\n";

if (!empty($errors)) {
    echo "Errors:\n";
    foreach ($errors as $error) {
        echo "  - {$error}\n";
    }
}
