<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pet;
use App\Models\PetInfo;
use Carbon\Carbon;

class ImportPetInfoCsv extends Command
{
    protected $signature = 'import:pet-info-csv 
                            {--path= : Path to CSV file}
                            {--dry-run : Run without actually inserting}';
    protected $description = 'Import pet_info data from CSV with exact pet_age calculated from pets.birthdate';

    public function handle()
    {
        $path = $this->option('path') ?? 'C:/Users/Admin/Downloads/pet_registration_data.csv';
        
        if (!file_exists($path)) {
            $this->error("CSV file not found: {$path}");
            return 1;
        }

        $csv = array_map('str_getcsv', file($path));
        $headers = array_shift($csv);
        
        $this->info("Found " . count($csv) . " rows in CSV");
        
        $records = [];
        $skipped = 0;
        $errors = [];

        foreach ($csv as $index => $row) {
            if (count($row) < count($headers)) {
                $skipped++;
                continue;
            }

            $data = array_combine($headers, $row);
            $petId = (int) $data['pet_id'];

            $pet = Pet::find($petId);
            if (!$pet) {
                $skipped++;
                $errors[] = "Row " . ($index + 2) . ": pet_id {$petId} not found in pets table";
                continue;
            }

            $petAge = $this->calculateExactAge($pet->birthdate);

            $records[] = [
                'pet_id'        => $petId,
                'is_neutered'   => $data['is_neutered'] ?? null,
                'is_crossbreed' => $data['is_crossbreed'] ?? null,
                'pet_age'       => $petAge,
                'pet_weight'    => $data['pet_weight'] ?? null,
                'training'      => json_encode($this->safeJsonDecode($data['training'] ?? '[]', "training row " . ($index + 2))),
                'insurance'     => json_encode($this->decodeInsurance($data['insurance'] ?? '')),
                'behavior'      => json_encode($this->safeJsonDecode($data['behavior'] ?? '[]', "behavior row " . ($index + 2))),
                'likes'         => json_encode($this->safeJsonDecode($data['likes'] ?? '[]', "likes row " . ($index + 2))),
                'dislikes'      => json_encode($this->safeJsonDecode($data['dislikes'] ?? '[]', "dislikes row " . ($index + 2))),
                'diet'          => json_encode($this->safeJsonDecode($data['diet'] ?? '[]', "diet row " . ($index + 2))),
                'allergy'       => json_encode($this->safeJsonDecode($data['allergy'] ?? '[]', "allergy row " . ($index + 2))),
                'created_at'    => $data['created_at'] ?? now(),
                'updated_at'    => $data['updated_at'] ?? now(),
            ];
        }

        $this->info("Prepared " . count($records) . " valid records");
        
        if ($skipped > 0) {
            $this->warn("Skipped {$skipped} rows");
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        if ($this->option('dry-run')) {
            $this->info('Dry run complete. No data inserted.');
            return 0;
        }

        if (empty($records)) {
            $this->warn('No records to insert.');
            return 0;
        }

        PetInfo::upsert(
            $records,
            ['pet_id'],
            [
                'is_neutered', 'is_crossbreed', 'pet_age', 'pet_weight',
                'training', 'insurance', 'behavior', 'likes', 'dislikes',
                'diet', 'allergy', 'created_at', 'updated_at',
            ]
        );

        $this->info('Import completed successfully.');
        return 0;
    }

    private function calculateExactAge($birthdate)
    {
        if (!$birthdate) {
            return null;
        }

        try {
            $birth = Carbon::parse($birthdate);
            $now = now();

            $years = (int) $birth->diffInYears($now);
            $months = (int) $birth->copy()->addYears($years)->diffInMonths($now);

            $parts = [];
            if ($years > 0) {
                $parts[] = $years . ' year' . ($years > 1 ? 's' : '');
            }
            if ($months > 0) {
                $parts[] = $months . ' month' . ($months > 1 ? 's' : '');
            }

            return $parts ? implode(' ', $parts) : '0 months';
        } catch (\Exception $e) {
            return null;
        }
    }

    private function safeJsonDecode($value, string $label)
    {
        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->warn("JSON decode failed for {$label}: " . json_last_error_msg());
            return null;
        }

        return $decoded;
    }

    private function decodeInsurance($value)
    {
        if (empty($value)) {
            return null;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return [$value];
    }
}
