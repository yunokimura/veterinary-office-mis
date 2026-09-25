<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\BiteRabiesReport;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BiteRabiesReportSeeder extends Seeder
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
        $names = [
            'Juan Dela Cruz', 'Maria Santos', 'Pedro Reyes', 'Ana Garcia', 'Jose Rizal',
            'Sofia Mendoza', 'Carlos Torres', 'Isabella Flores', 'Miguel Ramos', 'Valentina Cruz',
            'Diego Villanueva', 'Lucia Bautista', 'Antonio Manglapus', 'Elena Aquino', 'Francisco Sy'
        ];

        // Generate 50 records from last year
        $count = 0;
        $lastYear = Carbon::now()->subYear();
        $reportCounter = 1;

        for ($i = 0; $i < 50; $i++) {
            $incidentDate = Carbon::create($lastYear->year, rand(1, 12), rand(1, 28), rand(0, 23), rand(0, 59));
            $barangay = $barangays->random();
            
            // Generate unique report number
            $reportNumber = 'BR-' . $lastYear->year . '-' . str_pad($reportCounter++, 5, '0', STR_PAD_LEFT);
            
            // Split full name into parts
            $fullName = $names[array_rand($names)];
            $nameParts = explode(' ', $fullName);
            
            $patient = Patient::create([
                'first_name' => $nameParts[0] ?? 'Juan',
                'middle_name' => fake()->randomElement(['Dela', 'Del', 'De', 'D']),
                'last_name' => $nameParts[1] ?? 'Cruz',
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
                'rabies_confirmed' => rand(0, 1) == 1,
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

        $this->command->info('✅ Seeded ' . $count . ' bite rabies reports from last year.');
        $this->command->info('   - Status: All Resolved');
        $this->command->info('   - Rabies Confirmed: Randomized (50% chance)');
        $this->command->info('   - Date Range: ' . $lastYear->format('Y-m-d') . ' to ' . $lastYear->endOfYear()->format('Y-m-d'));
    }
}