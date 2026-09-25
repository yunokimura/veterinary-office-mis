<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- Columns in vaccination_appointments ---\n";
$columns = DB::select("SHOW COLUMNS FROM vaccination_appointments");
foreach ($columns as $col) {
    echo $col->Field . ' ' . $col->Type . PHP_EOL;
}

echo "\n--- Indexes in vaccination_appointments ---\n";
$indexes = DB::select("SHOW INDEX FROM vaccination_appointments WHERE Key_name != 'PRIMARY'");
foreach ($indexes as $idx) {
    echo $idx->Key_name . ' ' . $idx->Column_name . PHP_EOL;
}

echo "\n--- Foreign keys in vaccination_appointments ---\n";
$fks = DB::select("SELECT CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'vaccination_appointments' AND REFERENCED_TABLE_NAME IS NOT NULL");
foreach ($fks as $fk) {
    echo $fk->CONSTRAINT_NAME . ' ' . $fk->COLUMN_NAME . ' -> ' . $fk->REFERENCED_TABLE_NAME . '(' . $fk->REFERENCED_COLUMN_NAME . ')' . PHP_EOL;
}
