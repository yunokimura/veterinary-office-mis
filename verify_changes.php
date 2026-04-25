<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Check pets columns
$cols = Schema::getColumnListing('pets');
echo "pet_status column definition:\n";
$row = DB::select("SHOW COLUMNS FROM pets LIKE 'pet_status'");
if ($row) {
    print_r($row[0]);
}

// Check distinct pet_status values
$vals = DB::table('pets')->select('pet_status')->distinct()->get();
echo "\nDistinct pet_status values:\n";
foreach ($vals as $v) {
    echo '- '.$v->pet_status."\n";
}

// Check if adoption_pets exists
echo "\nadoption_pets exists: ".(Schema::hasTable('adoption_pets') ? 'yes' : 'no')."\n";

// Check pet_traits exists
echo 'pet_traits exists: '.(Schema::hasTable('pet_traits') ? 'yes' : 'no')."\n";
