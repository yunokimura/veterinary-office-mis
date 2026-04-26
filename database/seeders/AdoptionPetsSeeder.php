<?php

namespace Database\Seeders;

use App\Models\AdoptionTrait;
use App\Models\Pet;
use Illuminate\Database\Seeder;

class AdoptionPetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all available traits for random assignment
        $allTraits = AdoptionTrait::all();
        if ($allTraits->isEmpty()) {
            $this->command->warn('No adoption traits found. Run AdoptionTraitsSeeder first.');

            return;
        }

        // Define 15 pets matching existing images in public/images/adoption pets/
        // Only uses columns that actually exist in pets table
        $pets = [
            // DOGS (8)
            [
                'pet_name' => 'Buster',
                'species' => 'Dog',
                'breed' => 'Labrador Retriever',
                'gender' => 'male',
                'birthdate' => '2021-06-15',
                'pet_weight' => '28 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/buster.jpg',
            ],
            [
                'pet_name' => 'Chase',
                'species' => 'Dog',
                'breed' => 'German Shepherd',
                'gender' => 'male',
                'birthdate' => '2020-09-20',
                'pet_weight' => '32 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/chase.jpg',
            ],
            [
                'pet_name' => 'Cozmo',
                'species' => 'Dog',
                'breed' => 'Corgi',
                'gender' => 'male',
                'birthdate' => '2022-07-20',
                'pet_weight' => '12 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/cozmo.jpg',
            ],
            [
                'pet_name' => 'Oliver',
                'species' => 'Dog',
                'breed' => 'Pomeranian',
                'gender' => 'male',
                'birthdate' => '2022-11-05',
                'pet_weight' => '4 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/oliver.jpg',
            ],
            [
                'pet_name' => 'Shadow',
                'species' => 'Dog',
                'breed' => 'Siberian Husky',
                'gender' => 'male',
                'birthdate' => '2021-12-01',
                'pet_weight' => '22 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/shadow.jpg',
            ],
            [
                'pet_name' => 'James',
                'species' => 'Dog',
                'breed' => 'Beagle',
                'gender' => 'male',
                'birthdate' => '2022-03-18',
                'pet_weight' => '11 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/james.jpg',
            ],
            [
                'pet_name' => 'Mark',
                'species' => 'Dog',
                'breed' => 'Aspin',
                'gender' => 'male',
                'birthdate' => '2023-01-25',
                'pet_weight' => '13 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/mark.jpg',
            ],
            [
                'pet_name' => 'Benson',
                'species' => 'Dog',
                'breed' => 'Golden Retriever',
                'gender' => 'male',
                'birthdate' => '2021-08-10',
                'pet_weight' => '30 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/benson.jpg',
            ],

            // CATS (7)
            [
                'pet_name' => 'Bella',
                'species' => 'Cat',
                'breed' => 'Puspin',
                'gender' => 'female',
                'birthdate' => '2022-08-10',
                'pet_weight' => '3.5 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/bella.jpg',
            ],
            [
                'pet_name' => 'Daisy',
                'species' => 'Cat',
                'breed' => 'Puspin',
                'gender' => 'female',
                'birthdate' => '2023-02-14',
                'pet_weight' => '3.2 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/daisy.jpg',
            ],
            [
                'pet_name' => 'Lottie',
                'species' => 'Cat',
                'breed' => 'Persian',
                'gender' => 'female',
                'birthdate' => '2021-04-12',
                'pet_weight' => '4.2 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/lottie.jpg',
            ],
            [
                'pet_name' => 'Naya',
                'species' => 'Cat',
                'breed' => 'Siamese',
                'gender' => 'female',
                'birthdate' => '2022-11-30',
                'pet_weight' => '3.8 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/naya.jpg',
            ],
            [
                'pet_name' => 'Leekie',
                'species' => 'Cat',
                'breed' => 'Scottish Fold',
                'gender' => 'female',
                'birthdate' => '2023-03-18',
                'pet_weight' => '3.6 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/leekie.jpg',
            ],
            [
                'pet_name' => 'Xioming',
                'species' => 'Cat',
                'breed' => 'Ragdoll',
                'gender' => 'female',
                'birthdate' => '2022-06-25',
                'pet_weight' => '4.5 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/xioming.jpg',
            ],
            [
                'pet_name' => 'Smokey',
                'species' => 'Cat',
                'breed' => 'Russian Blue',
                'gender' => 'female',
                'birthdate' => '2023-01-08',
                'pet_weight' => '4.0 kg',
                'is_neutered' => false,
                'is_crossbreed' => false,
                'vaccination_status' => 'vaccinated',
                'pet_image' => 'images/adoption pets/smokey.jpg',
            ],
        ];

        $now = now();

        foreach ($pets as $petData) {
            // Use updateOrCreate to ensure existing pets get updated with correct data
            $pet = Pet::updateOrCreate(
                ['pet_name' => $petData['pet_name'], 'species' => $petData['species']],
                array_merge($petData, [
                    'source_module' => 'adoption_pets',
                    'source_module_id' => null,
                    'pet_status' => 'available',
                    'is_approved' => true,
                    'owner_id' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );

            // Attach 2–3 random traits
            $traitCount = rand(2, 3);
            $randomTraits = $allTraits->random($traitCount)->pluck('id')->toArray();
            $pet->traits()->sync($randomTraits);
        }
    }
}
