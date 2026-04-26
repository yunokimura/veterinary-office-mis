<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$columns = Schema::getColumnListing('pet_owners');
echo "Pet Owners Table Columns:\n";
foreach ($columns as $col) {
    echo "  - $col\n";
}
