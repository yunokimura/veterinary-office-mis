<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = DB::select("SHOW COLUMNS FROM pets WHERE Field = 'owner_id'");
foreach ($columns as $col) {
    echo "Field: {$col->Field}, Type: {$col->Type}, Key: {$col->Key}\n";
}

$pet = DB::table('pets')->where('owner_id', 6)->first();
if ($pet) {
    echo "\nPet with owner_id=6: {$pet->pet_name}\n";
}

$po = DB::table('pet_owners')->where('owner_id', 6)->first();
if ($po) {
    echo "PetOwner owner_id=6: {$po->first_name} {$po->last_name}, user_id: {$po->user_id}\n";
}

$user = DB::table('users')->where('id', 6)->first();
if ($user) {
    echo "User id=6: {$user->name}\n";
}
