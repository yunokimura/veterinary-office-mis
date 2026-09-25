<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- Indexes in vaccination_reports ---\n";
$indexes = DB::select("SHOW INDEX FROM vaccination_reports WHERE Key_name != 'PRIMARY'");
foreach ($indexes as $idx) {
    echo $idx->Key_name . ' ' . $idx->Column_name . PHP_EOL;
}
