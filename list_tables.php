<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
echo "All tables:\n";
foreach ($tables as $t) {
    $obj = (object) $t;
    echo array_values((array) $obj)[0]."\n";
}
