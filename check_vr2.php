<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- Foreign keys in vaccination_reports ---\n";
$fks = DB::select("SELECT CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'vaccination_reports' AND REFERENCED_TABLE_NAME IS NOT NULL");
foreach ($fks as $fk) {
    echo $fk->CONSTRAINT_NAME . ' ' . $fk->COLUMN_NAME . ' -> ' . $fk->REFERENCED_TABLE_NAME . '(' . $fk->REFERENCED_COLUMN_NAME . ')' . PHP_EOL;
}

if (empty($fks)) {
    echo "No foreign keys found\n";
}

echo "\n--- Indexes in vaccination_reports ---\n";
$indexes = DB::select("SHOW INDEX FROM vaccination_reports WHERE Key_name != 'PRIMARY'");
foreach ($indexes as $idx) {
    echo $idx->Key_name . ' ' . $idx->Column_name . PHP_EOL;
}
