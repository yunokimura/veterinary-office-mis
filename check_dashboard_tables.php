<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = [
    'barangays',
    'rabies_reports',
    'rabies_vaccination_reports',
    'vaccination_reports',
    'addresses',
    'adoption_applications',
    'missing_pets_reports',
    'meat_establishments'
];

echo "=== City Vet Dashboard Tables Status ===\n\n";

foreach ($tables as $table) {
    try {
        $count = DB::table($table)->count();
        $status = $count > 0 ? "✅ HAS DATA ($count records)" : "❌ EMPTY";
        echo sprintf("%-30s %s\n", $table, $status);
    } catch (Exception $e) {
        echo sprintf("%-30s ⚠️  ERROR: %s\n", $table, $e->getMessage());
    }
}

echo "\n=== Summary ===\n";
$emptyTables = array_filter($tables, function($table) {
    try {
        return DB::table($table)->count() === 0;
    } catch (Exception $e) {
        return true;
    }
});

if (empty($emptyTables)) {
    echo "All tables have data. No seeders needed.\n";
} else {
    echo "Tables needing seeders:\n";
    foreach ($emptyTables as $table) {
        echo "  - $table\n";
    }
}