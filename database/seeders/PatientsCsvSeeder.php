<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientsCsvSeeder extends Seeder
{
    public function run(): void
    {
        $path = 'C:/Users/Admin/Downloads/patients_30.csv';

        if (!file_exists($path)) {
            $this->command->error("CSV file not found: $path");
            return;
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            $this->command->error("Unable to open CSV file: $path");
            return;
        }

        $header = fgetcsv($handle);
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < count($header)) {
                $row = array_pad($row, count($header), null);
            }

            $data = array_combine($header, $row);

            Patient::create([
                'first_name'     => $data['first_name'] ?? null,
                'middle_name'    => $data['middle_name'] ?? null,
                'last_name'      => $data['last_name'] ?? null,
                'suffix'         => $data['suffix'] ?: null,
                'date_of_birth'  => $data['date_of_birth'] ?: null,
                'age'            => $data['age'] !== '' ? (int) $data['age'] : null,
                'gender'         => $data['gender'] ?? null,
                'contact_number' => $data['contact_number'] ?? null,
                'address'        => $data['address'] ?? null,
                'barangay_id'    => $data['barangay_id'] ? (int) $data['barangay_id'] : null,
                'created_at'     => $data['created_at'] ?: now(),
                'updated_at'     => $data['updated_at'] ?: now(),
            ]);

            $count++;
        }

        fclose($handle);
        $this->command->info("Seeded $count patients from CSV.");
    }
}
