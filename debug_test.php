<?php

use App\Models\PetOwner;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
/** @var Application $app */
$app->make(Kernel::class)->bootstrap();

echo "=== DEBUG TEST: Checking PetOwner table structure ===\n\n";

// Let's try to get the actual table structure from a working model
try {
    // First, let's see what columns the model expects
    $reflection = new ReflectionModel(new PetOwner);
    $properties = $reflection->getDefaultProperties();
    echo "PetOwner model fillable properties:\n";
    foreach ($properties['fillable'] as $field) {
        echo "  - {$field}\n";
    }
    echo "\n";

    // Now let's try to create a MINIMAL pet owner to see what fails
    $user = User::create([
        'first_name' => 'Debug',
        'last_name' => 'User',
        'email' => 'debug'.time().'@example.com',
        'password' => bcrypt('secret'),
        'status' => 'active',
    ]);

    echo "✓ Debug user created: ID {$user->id}\n";

    // Try with just the basics that we know should exist from the original migration
    $petOwner = PetOwner::create([
        'user_id' => $user->id,
        'first_name' => 'Debug',
        'last_name' => 'User',
    ]);

    echo "✓ Minimal pet owner created: ID {$petOwner->owner_id}\n";
    echo '  Has address_id column: '.(isset($petOwner->address_id) ? 'YES' : 'NO')."\n";
    if (isset($petOwner->address_id)) {
        echo '  address_id value: '.($petOwner->address_id ?? 'NULL')."\n";
    }

    // Clean up
    $petOwner->delete();
    $user->delete();

} catch (Exception $e) {
    echo '✗ Error: '.$e->getMessage()."\n";
    echo 'Error code: '.$e->getCode()."\n";

    // Show more detailed error info if possible
    if ($e->getPrevious()) {
        echo 'Previous error: '.$e->getPrevious()->getMessage()."\n";
    }
}

// Let's also check what migrations have been run
echo "\n=== CHECKING MIGRATION STATUS ===\n";
try {
    $migrated = DB::table('migrations')->orderBy('id')->get();
    foreach ($migrated as $migration) {
        if (strpos($migration->migration, 'pet_owners') !== false) {
            echo "Pet owners migration: {$migration->migration} - {$migration->batch}\n";
        }
    }
} catch (Exception $e) {
    echo 'Could not check migrations: '.$e->getMessage()."\n";
}

// Helper class to get reflection on models
class ReflectionModel extends ReflectionClass
{
    public function __construct($model)
    {
        parent::__construct(get_class($model));
    }

    public function getDefaultProperties()
    {
        $reflection = new ReflectionObject($this->newInstanceWithoutConstructor());
        $properties = [];
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($reflection->getValue($this->newInstanceWithoutConstructor()));
        }

        return $properties;
    }
}
