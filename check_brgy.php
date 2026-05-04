<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Address;

echo "=== Addresses with empty barangay_id ===\n";

$addrs = Address::whereNull('barangay_id')->orWhere('barangay_id', '')->get();

foreach ($addrs as $a) {
    echo "ID: {$a->id}, barangay_id: '{$a->barangay_id}', block_lot: {$a->block_lot_phase}, street: {$a->street}\n";
}
echo 'Total: '.$addrs->count()."\n";

echo "\n=== All Addresses ===\n";
$all = Address::all();
foreach ($all as $a) {
    echo "ID: {$a->id}, brgy_id: '{$a->barangay_id}', brgy_name: ".($a->barangay?->barangay_name ?? 'NULL')."\n";
}
