<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$addresses = \App\Models\RabiesVaccinationReport::select('id', 'patient_address')->limit(10)->get();

echo "Sample Patient Addresses:\n";
echo str_repeat("=", 80) . "\n";

foreach ($addresses as $record) {
    echo "ID: {$record->id}\n";
    echo "Address: {$record->patient_address}\n";
    echo str_repeat("-", 80) . "\n";
}