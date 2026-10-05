<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Sample pet ages:\n";
$pets = DB::table('pets')
    ->join('pet_info', 'pets.pet_id', '=', 'pet_info.pet_id')
    ->whereNotNull('pets.birthdate')
    ->limit(10)
    ->get(['pets.pet_id', 'pets.birthdate', 'pet_info.pet_age']);

foreach ($pets as $p) {
    echo "Pet {$p->pet_id}: {$p->birthdate} => {$p->pet_age}\n";
}
