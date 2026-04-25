<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== DATABASE SCHEMA VERIFICATION ===\n\n";

// Check key tables exist
$tables = ['pets', 'adoption_applications', 'adoption_selected_pets', 'adoption_pets', 'pet_traits', 'missing_pets', 'missing_pets_reports'];
foreach ($tables as $table) {
    $exists = Schema::hasTable($table);
    echo "$table: ".($exists ? 'EXISTS' : 'MISSING')."\n";
}

echo "\n=== PETS TABLE COLUMNS ===\n";
$cols = Schema::getColumnListing('pets');
echo implode(', ', $cols)."\n";

echo "\n=== PET_STATUS ENUM VALUES ===\n";
$row = DB::select("SHOW COLUMNS FROM pets LIKE 'pet_status'");
if ($row) {
    preg_match_all("/'([^']+)'/", $row[0]->Type, $matches);
    echo 'Enum values: '.implode(', ', $matches[1])."\n";
    echo 'Default: '.$row[0]->Default."\n";
    echo 'Nullable: '.($row[0]->Null === 'NO' ? 'NO' : 'YES')."\n";
}

echo "\n=== PET_TRAITS FOREIGN KEYS ===\n";
$res = DB::select('SHOW CREATE TABLE pet_traits');
echo $res[0]->{'Create Table'}."\n";

echo "\n=== SAMPLE PET DATA ===\n";
$pets = DB::table('pets')->select('pet_id', 'pet_name', 'pet_status', 'source_module')->limit(5)->get();
foreach ($pets as $pet) {
    echo "ID: {$pet->pet_id}, Name: {$pet->pet_name}, Status: {$pet->pet_status}, Source: {$pet->source_module}\n";
}
