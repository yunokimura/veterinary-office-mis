<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- vaccination_appointments ---\n";
$appointments = DB::table('vaccination_appointments')->get();
foreach ($appointments as $a) {
    echo "ID: {$a->id}, Owner: {$a->owner_id}, Pet: " . ($a->metadata['selected_pets'][0]['name'] ?? 'N/A') . ", Status: {$a->status}\n";
}

echo "\n--- vaccination_reports ---\n";
$reports = DB::table('vaccination_reports')->get();
foreach ($reports as $r) {
    echo "ID: {$r->id}, Appointment: {$r->vaccination_appointment_id}, Pet: {$r->pet_id} ({$r->pet_name}), Vaccine: {$r->vaccine_brand}, Status: {$r->status}\n";
}

echo "\n--- inventory_controls ---\n";
$inventory = DB::table('inventory_controls')->get();
foreach ($inventory as $i) {
    echo "ID: {$i->id}, Item: {$i->item_name} ({$i->item_code}), Qty: {$i->quantity}\n";
}
