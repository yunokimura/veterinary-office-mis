<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::dropIfExists('vaccination_appointments');
Schema::create('vaccinations', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('pet_id');
    $table->unsignedBigInteger('vaccinated_by');
    $table->string('vaccine_type')->default('Rabies');
    $table->date('vaccination_date');
    $table->date('next_vaccination_date')->nullable();
    $table->string('batch_number')->nullable();
    $table->string('veterinarian')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();

    $table->index('pet_id');
    $table->index('vaccinated_by');
    $table->index('vaccination_date');
});

DB::statement('ALTER TABLE vaccinations ADD CONSTRAINT vaccinations_pet_id_foreign FOREIGN KEY (pet_id) REFERENCES pets(pet_id) ON DELETE CASCADE');
DB::statement('ALTER TABLE vaccinations ADD CONSTRAINT vaccinations_vaccinated_by_foreign FOREIGN KEY (vaccinated_by) REFERENCES users(id) ON DELETE CASCADE');

echo "Recreated vaccinations table\n";
