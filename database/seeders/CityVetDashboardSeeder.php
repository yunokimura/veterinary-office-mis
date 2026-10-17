<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\Pet;
use App\Models\PetInfo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CityVetDashboardSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for faster seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->command->info('Seeding City Vet Dashboard data...');

        // Truncate tables to avoid duplicates
        DB::table('meat_establishments')->truncate();
        DB::table('vaccination_reports')->truncate();
        DB::table('rabies_vaccination_reports')->truncate();
        DB::table('adoption_applications')->truncate();
        DB::table('missing_pets_reports')->truncate();

        // Seed in order of dependencies
        $this->seedMeatEstablishments();
        $this->command->info('✓ Meat establishments seeded');

        $this->seedVaccinationReports();
        $this->command->info('✓ Vaccination reports seeded');

        $this->seedRabiesVaccinationReports();
        $this->command->info('✓ Rabies vaccination reports seeded');

        $this->seedAdoptionApplications();
        $this->command->info('✓ Adoption applications seeded');

        $this->seedMissingPetsReports();
        $this->command->info('✓ Missing pets reports seeded');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('✅ City Vet Dashboard seeding complete!');
    }

    private function seedMeatEstablishments(): void
    {
        $establishments = [
            ['Dasmariñas Meat Market', 'meat_shop', 'Juan Dela Cruz', 'Pedro Santos', '09123456789', 'meat@email.com', '2024-01-15', '2025-01-15'],
            ['Paliparan Meat Shop', 'meat_shop', 'Maria Garcia', 'Ana Reyes', '09234567890', 'paliparan@email.com', '2024-02-20', '2025-02-20'],
            ['Zone 3 Poultry Dealer', 'poultry_farm', 'Jose Ramos', 'Carlos Mendez', '09345678901', 'poultry@email.com', '2024-03-10', '2025-03-10'],
            ['Salitran Pork Center', 'meat_processing_plant', 'Elena Cruz', 'Miguel Torres', '09456789012', 'salitran@email.com', '2023-06-01', '2024-06-01'],
            ['Burol Meat Stall', 'meat_shop', 'Rosa Villanueva', 'Luis Fernandez', '09567890123', 'burol@email.com', '2024-05-01', '2025-05-01'],
            ['Langkaan II Meat Shop', 'meat_shop', 'Antonio Lim', 'Sofia Reyes', '09678901234', 'langkaan@email.com', '2024-04-12', '2025-04-12'],
            ['Sampalukan Meat Market', 'meat_shop', 'Carmen Diaz', 'Diego Villar', '09789012345', 'sampalukan@email.com', '2024-01-20', '2025-01-20'],
            ['San Agustin Poultry', 'poultry_farm', 'Francisco Santos', 'Isabella Cruz', '09890123456', 'sanagustin@email.com', '2024-03-05', '2025-03-05'],
        ];

        foreach ($establishments as $est) {
            DB::table('meat_establishments')->insert([
                'establishment_name' => $est[0],
                'establishment_type' => $est[1],
                'owner_name' => $est[2],
                'contact_person' => $est[3],
                'contact_number' => $est[4],
                'email' => $est[5],
                'address_text' => fake()->streetAddress().', Dasmariñas City',
                'barangay_id' => Barangay::inRandomOrder()->first()->barangay_id,
                'inspection_date' => $est[6],
                'status' => $est[6] < '2024-01-01' ? 'Expired' : (rand(0, 1) ? 'Active' : 'Pending Inspection'),
                'permit_expiry_date' => $est[7],
                'registered_by_user_id' => User::first()->id ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function seedVaccinationReports(): void
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['clinic', 'hospital']);
        })->get();

        if ($users->isEmpty()) {
            $users = User::limit(3)->get();
        }

        $statuses = ['pending', 'approved', 'completed', 'cancelled', 'no_show'];

        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $scheduledAt = Carbon::now()->addDays(rand(-30, 30))->addHours(rand(8, 17));

            DB::table('vaccination_reports')->insert([
                'user_id' => $user->id,
                'owner_id' => rand(1, 10),
                'address_id' => rand(1, 7),
                'scheduled_at' => $scheduledAt,
                'last_anti_rabies_date' => rand(0, 1) ? Carbon::now()->subMonths(rand(6, 24)) : null,
                'recent_surgery' => rand(0, 1) ? 1 : 0,
                'status' => $status,
                'metadata' => json_encode([
                    'selected_pets' => [rand(1, 100)],
                ]),
                'created_at' => Carbon::now()->subDays(rand(0, 60)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function seedRabiesVaccinationReports(): void
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['clinic', 'hospital']);
        })->get();

        if ($users->isEmpty()) {
            $users = User::limit(3)->get();
        }

        $vaccineBrands = ['Rabisin', 'Rabivac', 'Nobivac', 'Imrab', 'RabAvert'];
        $statuses = ['completed', 'pending', 'adverse_reaction'];
        $vaccinationTypes = ['primary', 'booster'];
        $animalTypes = ['dog', 'cat'];

        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $vaccinationDate = Carbon::now()->subDays(rand(0, 365));

            DB::table('rabies_vaccination_reports')->insert([
                'user_id' => $user->id,
                'clinic_name' => fake()->company().' Veterinary Clinic',
                'patient_name' => fake()->name(),
                'patient_contact' => '09'.rand(100000000, 999999999),
                'patient_address' => fake()->address(),
                'pet_name' => fake()->firstName(),
                'pet_species' => $animalTypes[array_rand($animalTypes)],
                'pet_breed' => fake()->randomElement(['Aspin', 'Puspin', 'Labrador', 'Poodle', 'Shih Tzu', 'Mongrel']),
                'pet_age' => rand(1, 15),
                'pet_gender' => fake()->randomElement(['male', 'female']),
                'pet_color' => fake()->randomElement(['Brown', 'Black', 'White', 'Golden', 'Gray', 'Orange']),
                'vaccine_brand' => $vaccineBrands[array_rand($vaccineBrands)],
                'vaccine_batch_number' => 'BATCH-'.strtoupper(fake()->bothify('??###')),
                'vaccination_date' => $vaccinationDate,
                'vaccination_time' => Carbon::parse(rand(8, 17).':'.str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT)),
                'next_vaccination_date' => $status === 'completed' ? $vaccinationDate->copy()->addYear() : null,
                'weight' => rand(100, 35000) / 100,
                'vaccination_type' => $vaccinationTypes[array_rand($vaccinationTypes)],
                'observations' => fake()->sentence(),
                'status' => $status,
                'notes' => fake()->optional(0.3)->sentence(),
                'created_at' => $vaccinationDate,
                'updated_at' => $vaccinationDate,
            ]);
        }
    }

    private function seedAdoptionApplications(): void
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['pet_owner', 'citizen']);
        })->get();

        if ($users->isEmpty()) {
            $users = User::limit(5)->get();
        }

        $statuses = ['pending_review', 'approved', 'rejected', 'adopted'];
        $pets = Pet::where('source_module', 'adoption_pets')->get();

        if ($pets->isEmpty()) {
            $petIds = range(1, 10);
        } else {
            $petIds = $pets->pluck('pet_id')->toArray();
        }

        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $createdAt = Carbon::now()->subDays(rand(0, 90));

            DB::table('adoption_applications')->insert([
                'user_id' => $user->id,
                'owner_id' => rand(1, 10),
                'address_id' => rand(1, 7),
                'selected_pet_id' => $petIds[array_rand($petIds)],
                'company' => fake()->company(),
                'occupation' => fake()->jobTitle(),
                'social_media' => fake()->optional(0.5)->userName(),
                'marital_status' => ['Single', 'Married', 'Others'][rand(0, 2)],
                'adopted_before' => rand(0, 1) ? 'yes' : 'no',
                'status' => $status,
                'alternate_contact' => json_encode(['name' => fake()->name(), 'phone' => '09'.rand(100000000, 999999999)]),
                'questionnaire' => json_encode(['q1' => 'Yes', 'q2' => 'No']),
                'valid_id_path' => fake()->optional(0.7)->filePath(),
                'appointment_date' => rand(0, 1) ? Carbon::now()->addDays(rand(7, 21))->format('Y-m-d') : null,
                'appointment_time' => rand(0, 1) ? Carbon::parse(rand(9, 16).':00')->format('H:i:s') : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }

    private function seedMissingPetsReports(): void
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['pet_owner', 'citizen']);
        })->get();

        if ($users->isEmpty()) {
            $users = User::limit(5)->get();
        }

        $pets = Pet::inRandomOrder()->limit(20)->get();
        $barangays = Barangay::inRandomOrder()->get();
        $statuses = ['missing', 'found', 'reunited'];
        $eyeColors = ['Brown', 'Blue', 'Green', 'Amber', 'Gray'];

        for ($i = 0; $i < 12; $i++) {
            $user = $users->random();
            $pet = $pets->random();
            $barangay = $barangays->random();
            $status = $statuses[array_rand($statuses)];
            $lastSeen = Carbon::now()->subDays(rand(0, 60));

            DB::table('missing_pets_reports')->insert([
                'user_id' => $user->id,
                'pet_id' => $pet->pet_id,
                'body_marks' => fake()->optional(0.6)->sentence(),
                'collar_harness' => fake()->randomElement(['Red Collar', 'Blue Harness', 'None', 'Green Collar']),
                'last_seen_at' => $lastSeen,
                'barangay_id' => $barangay->barangay_id,
                'location_description' => fake()->optional(0.7)->sentence(),
                'emergency_contact' => '09'.rand(100000000, 999999999),
                'status' => $status,
                'created_at' => $lastSeen,
                'updated_at' => $status === 'reunited' ? $lastSeen->copy()->addDays(rand(1, 14)) : $lastSeen,
            ]);

            PetInfo::updateOrCreate(
                ['pet_id' => $pet->pet_id],
                ['eye_color' => $eyeColors[array_rand($eyeColors)]]
            );
        }
    }
}
