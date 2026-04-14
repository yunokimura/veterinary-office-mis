<?php

namespace Database\Seeders;

use App\Models\BiteRabiesReport;
use App\Models\Barangay;
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
                'patient_name' => 'Juan dela Cruz',
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
                'patient_name' => 'Ana Reyes',
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
                'patient_name' => 'Michael Tan',
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
                'patient_name' => 'Sofia Garcia',
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
                'patient_name' => 'Carlo Mendoza',
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
                'patient_name' => 'Maria Lopez',
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
                'patient_name' => 'David Kim',
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
                'patient_name' => 'Emily Cruz',
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
                'patient_name' => 'James Wilson',
                'age' => 41,
                'gender' => 'Male',
                'exposure_type' => 'bite',
                'bite_site' => 'Upper Extremities',
                'category' => 'II',
                'animal_type' => 'dog',
                'animal_status' => 'wild',
                'animal_owner_name' => null,
                'vaccination_status' => 'unknown',
                'incident_date' => now()->subDays(10),
            ],
            [
                'patient_name' => 'Patricia Yu',
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
                $data['report_number'] = BiteRabiesReport::generateReportNumber();
                $data['status'] = 'Pending Review';
                $data['reporting_facility'] = 'Staff Entry';
                $data['barangay_id'] = $barangay->barangay_id;
                $data['patient_contact'] = '09123456789';

                BiteRabiesReport::create($data);
                $count++;
            }
        }

        $this->command->info("Created {$count} Bite & Rabies Reports successfully!");
    }
}
