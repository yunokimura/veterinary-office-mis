<?php

namespace Database\Seeders;

use App\Models\BiteRabiesReport;
use App\Models\Barangay;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class AnimalBiteReportSeeder extends Seeder
{
    public function run(): void
    {
        $barangays = Barangay::where('city', 'dasmarinas')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->limit(10)
            ->get();

        if ($barangays->isEmpty()) {
            $this->command->warn('No barangays found in Dasmariñas city. Please run BarangaySeeder first.');
            return;
        }

        $reports = [
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'age' => 25,
                'gender' => 'Male',
                'exposure_type' => 'bite',
                'bite_site' => 'Upper Extremities',
                'category' => 'II',
                'animal_type' => 'dog',
                'animal_status' => 'owned',
                'animal_owner_name' => 'Maria Santos',
                'vaccination_status' => 'unknown',
                'incident_date' => now()->subDays(5),
            ],
            [
                'first_name' => 'Ana',
                'last_name' => 'Reyes',
                'age' => 8,
                'gender' => 'Female',
                'exposure_type' => 'bite',
                'bite_site' => 'Head/Neck',
                'category' => 'III',
                'animal_type' => 'dog',
                'animal_status' => 'stray',
                'animal_owner_name' => null,
                'vaccination_status' => 'unvaccinated',
                'incident_date' => now()->subDays(3),
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Tan',
                'age' => 34,
                'gender' => 'Male',
                'exposure_type' => 'scratch',
                'bite_site' => 'Upper Extremities',
                'category' => 'II',
                'animal_type' => 'cat',
                'animal_status' => 'owned',
                'animal_owner_name' => 'Lisa Chen',
                'vaccination_status' => 'vaccinated',
                'incident_date' => now()->subDays(7),
            ],
            [
                'first_name' => 'Sofia',
                'last_name' => 'Garcia',
                'age' => 45,
                'gender' => 'Female',
                'exposure_type' => 'bite',
                'bite_site' => 'Lower Extremities',
                'category' => 'III',
                'animal_type' => 'dog',
                'animal_status' => 'owned',
                'animal_owner_name' => 'Roberto Garcia',
                'vaccination_status' => 'unknown',
                'incident_date' => now()->subDays(2),
            ],
            [
                'first_name' => 'Carlo',
                'last_name' => 'Mendoza',
                'age' => 12,
                'gender' => 'Male',
                'exposure_type' => 'bite',
                'bite_site' => 'Trunk',
                'category' => 'III',
                'animal_type' => 'dog',
                'animal_status' => 'stray',
                'animal_owner_name' => null,
                'vaccination_status' => 'unvaccinated',
                'incident_date' => now()->subDays(1),
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Lopez',
                'age' => 28,
                'gender' => 'Female',
                'exposure_type' => 'bite',
                'bite_site' => 'Upper Extremities',
                'category' => 'I',
                'animal_type' => 'cat',
                'animal_status' => 'owned',
                'animal_owner_name' => 'Jenny Lopez',
                'vaccination_status' => 'vaccinated',
                'incident_date' => now()->subDays(4),
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Kim',
                'age' => 52,
                'gender' => 'Male',
                'exposure_type' => 'bite',
                'bite_site' => 'Lower Extremities',
                'category' => 'II',
                'animal_type' => 'dog',
                'animal_status' => 'owned',
                'animal_owner_name' => 'Sarah Kim',
                'vaccination_status' => 'vaccinated',
                'incident_date' => now()->subDays(6),
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Cruz',
                'age' => 5,
                'gender' => 'Female',
                'exposure_type' => 'bite',
                'bite_site' => 'Head/Neck',
                'category' => 'III',
                'animal_type' => 'dog',
                'animal_status' => 'owned',
                'animal_owner_name' => 'Tom Cruz',
                'vaccination_status' => 'vaccinated',
                'incident_date' => now()->subDays(8),
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Wilson',
                'age' => 41,
                'gender' => 'Male',
                'exposure_type' => 'bite',
                'bite_site' => 'Upper Extremities',
                'category' => 'II',
                'animal_type' => 'dog',
                'animal_status' => 'stray',
                'animal_owner_name' => null,
                'vaccination_status' => 'unknown',
                'incident_date' => now()->subDays(10),
            ],
            [
                'first_name' => 'Patricia',
                'last_name' => 'Yu',
                'age' => 19,
                'gender' => 'Female',
                'exposure_type' => 'scratch',
                'bite_site' => 'Upper Extremities',
                'category' => 'I',
                'animal_type' => 'cat',
                'animal_status' => 'stray',
                'animal_owner_name' => null,
                'vaccination_status' => 'unknown',
                'incident_date' => now()->subDays(9),
            ],
        ];

        $count = 0;
        foreach ($barangays as $index => $barangay) {
            if (isset($reports[$index])) {
                $data = $reports[$index];

                $patient = Patient::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'gender' => $data['gender'],
                    'contact_number' => '09123456789',
                    'barangay_id' => $barangay->barangay_id,
                    'age' => $data['age'],
                ]);

                BiteRabiesReport::create([
                    'report_number' => BiteRabiesReport::generateReportNumber(),
                    'status' => 'Pending Review',
                    'reporting_facility' => 'Staff Entry',
                    'patient_id' => $patient->id,
                    'barangay_id' => $barangay->barangay_id,
                    'incident_date' => $data['incident_date'],
                    'exposure_type' => $data['exposure_type'],
                    'bite_site' => $data['bite_site'],
                    'category' => $data['category'],
                    'animal_type' => $data['animal_type'],
                    'animal_status' => $data['animal_status'],
                    'animal_owner_name' => $data['animal_owner_name'],
                    'vaccination_status' => $data['vaccination_status'],
                ]);

                $count++;
            }
        }

        $this->command->info("Created {$count} Bite & Rabies Reports successfully!");
    }
}
