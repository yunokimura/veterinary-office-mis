<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Kapon (spay_neuter_reports) ===\n";
$kapon = DB::table('spay_neuter_reports')->get();
echo "Total records: " . $kapon->count() . "\n";

$dupes = DB::table('spay_neuter_reports')
    ->select('pet_name', 'scheduled_at', DB::raw('COUNT(*) as count'))
    ->groupBy('pet_name', 'scheduled_at')
    ->having('count', '>', 1)
    ->get();
echo "Duplicate entries (pet_name + date): " . $dupes->count() . "\n";
if ($dupes->count() > 0) {
    foreach ($dupes as $d) {
        echo "  - " . $d->pet_name . " on " . $d->scheduled_at . ": " . $d->count . "x\n";
    }
}

echo "\n=== Vaccination (vaccination_reports) ===\n";
$vax = DB::table('vaccination_reports')->get();
echo "Total records: " . $vax->count() . "\n";

$vaxDupes = DB::table('vaccination_reports')
    ->select('owner_first_name', 'owner_last_name', 'scheduled_at', DB::raw('COUNT(*) as count'))
    ->groupBy('owner_first_name', 'owner_last_name', 'scheduled_at')
    ->having('count', '>', 1)
    ->get();
echo "Duplicate entries (owner + date): " . $vaxDupes->count() . "\n";
if ($vaxDupes->count() > 0) {
    foreach ($vaxDupes as $d) {
        echo "  - " . $d->owner_first_name . " " . $d->owner_last_name . " on " . $d->scheduled_at . ": " . $d->count . "x\n";
    }
}

echo "\n=== Adoption (adoption_applications) ===\n";
$adopt = DB::table('adoption_applications')->get();
echo "Total records: " . $adopt->count() . "\n";

$adoptDupes = DB::table('adoption_applications')
    ->select('user_id', DB::raw('COUNT(*) as count'))
    ->groupBy('user_id')
    ->having('count', '>', 1)
    ->get();
echo "Duplicate entries (user_id): " . $adoptDupes->count() . "\n";
if ($adoptDupes->count() > 0) {
    foreach ($adoptDupes as $d) {
        echo "  - user_id " . $d->user_id . ": " . $d->count . "x\n";
    }
}

echo "\n=== Appointments ===\n";
$apt = DB::table('appointments')->get();
echo "Total records: " . $apt->count() . "\n";

$aptDupes = DB::table('appointments')
    ->select('appointment_date', 'appointment_time', 'service_type', DB::raw('COUNT(*) as count'))
    ->groupBy('appointment_date', 'appointment_time', 'service_type')
    ->having('count', '>', 1)
    ->get();
echo "Duplicate entries (date + time + type): " . $aptDupes->count() . "\n";
