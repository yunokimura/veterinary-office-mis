<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = DB::select("SHOW TABLES LIKE 'vaccination%'");
foreach ($tables as $t) {
    foreach ($t as $v) {
        echo $v . PHP_EOL;
    }
}

echo "--- Columns in vaccinations ---\n";
$columns = DB::select("SHOW COLUMNS FROM vaccinations");
foreach ($columns as $col) {
    echo $col->Field . ' ' . $col->Type . PHP_EOL;
}
