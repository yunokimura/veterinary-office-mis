<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$indexes = DB::select("SHOW INDEX FROM vaccinations WHERE Key_name != 'PRIMARY'");
foreach ($indexes as $idx) {
    echo $idx->Key_name . ' ' . $idx->Column_name . PHP_EOL;
}
