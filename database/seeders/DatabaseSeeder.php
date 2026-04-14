<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BarangaySeeder::class,
            SpatieRoleSeeder::class,
            TestAccountsSeeder::class,
            UserRoleSeeder::class,
            CreateRecordsStaffUser::class,
            AssignSpatieRolesSeeder::class,
            AdoptionTraitsSeeder::class,
            AdoptionPetsSeeder::class,
            // MissingPetsSeeder::class, // Commented out - model/migration mismatch
            AnnouncementSeeder::class,
            AnimalBiteReportSeeder::class,
            InventorySeeder::class,
            FacilitySeeder::class,
            SpayNeuterSeeder::class,
        ]);
    }
}
