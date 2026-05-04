<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Address;
use Illuminate\Support\Facades\DB;

echo "=== Direct DB Query ===\n";
$addresses = DB::table('addresses')->get();
foreach ($addresses as $addr) {
    echo 'ID: '.$addr->id.' | barangay_id: '.$addr->barangay_id.' | street: '.$addr->street.PHP_EOL;
}

echo "\n=== Eloquent Query ===\n";
$addresses = Address::all();
foreach ($addresses as $addr) {
    echo 'ID: '.$addr->id.' | barangay_id: '.$addr->barangay_id.' | street: '.$addr->street.PHP_EOL;

    // Check if barangay relationship exists
    if ($addr->barangay) {
        echo '  -> barangay_name: '.$addr->barangay->barangay_name.PHP_EOL;
    } else {
        echo '  -> barangay: NULL'.PHP_EOL;
    }
}
