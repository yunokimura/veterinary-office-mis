<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pets = App\Models\Pet::whereNotNull('birthdate')->get();
echo 'Count: ' . $pets->count() . PHP_EOL;
foreach ($pets as $i => $pet) {
    echo 'Pet ' . $i . ': ';
    echo ($pet instanceof App\Models\Pet ? 'OK - ' . $pet->birthdate : 'ARRAY - ' . print_r($pet, true));
    echo PHP_EOL;
    if ($i >= 2) break;
}