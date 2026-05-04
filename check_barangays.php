<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Barangay;

$barangays = Barangay::all();
echo 'Total barangays: '.$barangays->count().PHP_EOL;
foreach ($barangays as $b) {
    echo 'ID: '.$b->barangay_id.' | Name: '.$b->barangay_name.PHP_EOL;
}
