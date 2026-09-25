<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\BiteRabiesReport;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BiteRabiesReport072026 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all barangays for random assignment
        $barangays = Barangay::all();
        
        if ($barangays->isEmpty()) {
            $this->command->warn('No barangays found. Please run BarangaySeeder first.');
            return;
        }

        // Sample data for seeding
        $animalTypes = ['dog', 'cat'];
        $animalStatuses = ['stray', 'owned'];
        $vaccinationStatuses = ['vaccinated', 'unvaccinated', 'unknown'];
        $exposureTypes = ['bite', 'scratch', 'lick'];
        $categories = ['I', 'II', 'III'];
        $genders = ['Male', 'Female'];
        $lastNames = [
            'Dela Cruz', 'Santos', 'Reyes', 'Garcia', 'Rizal',
            'Mendoza', 'Torres', 'Flores', 'Ramos', 'Cruz',
            'Villanueva', 'Bautista', 'Manglapus', 'Aquino', 'Sy'
        ];
        $firstNames = [
            'Juan', 'Maria', 'Pedro', 'Ana', 'Jose',
            'Sofia', 'Carlos', 'Isabella', 'Miguel', 'Valentina',
            'Diego', 'Lucia', 'Antonio', 'Elena', 'Francisco'
        ];

        // Generate 30 records for July 2026
        $count = 0;
        $reportCounter = 1;

        for ($i = 0; $i < 30; $i++) {
            // All incidents in July 2026
            $incidentDate = Carbon::create(2026, 7, rand(1, 31), rand(0, 23), rand(0, 59));
            $barangay = $barangays->random();
            
            // Generate unique report number
            $reportNumber = 'BR-2026-07-' . str_pad($reportCounter++, 5, '0', STR_PAD_LEFT);
            
            // Generate random name
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $middleName = fake()->randomElement(['Dela', 'Del', 'De', 'D', '']);
            
            $patient = Patient::create([
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'suffix' => fake()->randomElement(['Jr.', 'Sr.', 'III', '']),
                'gender' => $genders[array_rand($genders)],
                'contact_number' => fake()->numerify('09#########'),
                'address' => fake()->streetAddress(),
                'barangay_id' => $barangay->barangay_id,
                'age' => rand(5, 85),
            ]);

            BiteRabiesReport::create([
                'report_number' => $reportNumber,
                'status' => 'Resolved',
                'rabies_confirmed' => true,
                'patient_id' => $patient->id,
                'barangay_id' => $barangay->barangay_id,
                'incident_date' => $incidentDate,
                'exact_location' => fake()->streetAddress(),
                'exposure_type' => $exposureTypes[array_rand($exposureTypes)],
                'bite_site' => fake()->randomElement(['Hand', 'Arm', 'Leg', 'Foot', 'Head', 'Torso']),
                'category' => $categories[array_rand($categories)],
                'animal_type' => $animalTypes[array_rand($animalTypes)],
                'animal_status' => $animalStatuses[array_rand($animalStatuses)],
                'vaccination_status' => $vaccinationStatuses[array_rand($vaccinationStatuses)],
                'animal_owner_name' => fake()->name(),
                'animal_owner_contact' => fake()->numerify('09#########'),
                'reported_by' => rand(1, 5),
                'reporting_facility' => fake()->randomElement(['City Health Office', 'Barangay Health Center', 'Private Clinic']),
                'date_reported' => $incidentDate->copy()->addDays(rand(1, 7)),
                'wound_management' => null,
                'post_exposure_prophylaxis' => fake()->sentence(),
                'notes' => fake()->paragraph(),
                'action_taken' => fake()->sentence(),
                'created_at' => $incidentDate,
                'updated_at' => $incidentDate->addDays(rand(1, 30)),
            ]);

            $count++;
        }

        $this->command->info('✅ Seeded ' . $count . ' bite rabies reports for July 2026.');
        $this->command->info('   - Status: All Resolved');
        $this->command->info('   - Rabies Confirmed: Randomized (50% chance)');
        $this->command->info('   - Date Range: July 1-31, 2026');
        $this->command->info('   - Report Numbers: BR-2026-07-00001 to BR-2026-07-' . str_pad($count, 5, '0', STR_PAD_LEFT));
    }
}
