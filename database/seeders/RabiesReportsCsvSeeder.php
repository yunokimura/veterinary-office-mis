<?php

namespace Database\Seeders;

use App\Models\BiteRabiesReport;
use Illuminate\Database\Seeder;

class RabiesReportsCsvSeeder extends Seeder
{
    public function run(): void
    {
        $path = 'C:/Users/Admin/Downloads/rabies_reports_30.csv';

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

            $barangayId = isset($data['barangay_id']) && $data['barangay_id'] !== '' ? (int) $data['barangay_id'] : null;

            $animalOwnerContact = isset($data['animal_owner_contact']) && $data['animal_owner_contact'] !== '' ? $data['animal_owner_contact'] : null;

            BiteRabiesReport::create([
                'report_number'           => $data['report_number'] ?? null,
                'date_reported'           => $data['date_reported'] ?: null,
                'barangay_id'             => $barangayId,
                'incident_date'           => $data['incident_date'] ?: null,
                'exact_location'          => $data['exact_location'] ?? null,
                'exposure_type'           => $data['exposure_type'] ?? null,
                'bite_site'               => $data['bite_site'] ?? null,
                'category'                => $data['category'] ?? null,
                'animal_type'             => $data['animal_type'] ?? null,
                'animal_status'           => $data['animal_status'] ?? null,
                'vaccination_status'      => $data['vaccination_status'] ?? null,
                'animal_owner_name'       => $data['animal_owner_name'] ?: null,
                'animal_owner_contact'    => $animalOwnerContact,
                'notes'                   => $data['notes'] ?? null,
                'action_taken'            => $data['action_taken'] ?? null,
                'created_at'              => $data['created_at'] ?: now(),
                'updated_at'              => $data['created_at'] ?: now(),
            ]);

            $count++;
        }

        fclose($handle);
        $this->command->info("Seeded $count rabies reports from CSV.");
    }
}
