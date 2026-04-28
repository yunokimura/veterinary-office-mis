<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Organization;
use App\Models\PetOwner;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates test accounts for all roles using Spatie
     */
    public function run(): void
    {
        // ==============================
        // THESIS ROLE 1: SUPER ADMIN
        // ==============================
        $firstName = 'Super';
        $lastName = 'Administrator';
        $contactNumber = '09198887701';

        $user1 = User::firstOrCreate(
            ['email' => 'superadmin@vetmis.gov'],
            [
                'email' => 'superadmin@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user1->assignRole('super_admin');
        Admin::firstOrCreate(
            ['user_id' => $user1->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role_type' => 'super_admin',
                'contact_number' => $contactNumber,
            ]
        );

        // ==============================
        // THESIS ROLE 2: CITY VETERINARIAN
        // ==============================
        $firstName = 'Maria';
        $lastName = 'Santos';
        $contactNumber = '091988877702';

        $user2 = User::firstOrCreate(
            ['email' => 'cityvet@vetmis.gov'],
            [
                'email' => 'cityvet@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user2->assignRole('city_vet');
        Admin::firstOrCreate(
            ['user_id' => $user2->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role_type' => 'city_vet',
                'contact_number' => $contactNumber,
            ]
        );

        // ==============================
        // THESIS ROLE 3: ADMINISTRATIVE STAFF
        // ==============================
        $firstName = 'Carmen';
        $lastName = 'Rivera';
        $contactNumber = '091988877703';

        $user3 = User::firstOrCreate(
            ['email' => 'adminstaff@vetmis.gov'],
            [
                'email' => 'adminstaff@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user3->assignRole('admin_staff');
        Admin::firstOrCreate(
            ['user_id' => $user3->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role_type' => 'admin_staff',
                'contact_number' => $contactNumber,
            ]
        );

        // ==============================
        // THESIS ROLE 4: ASSISTANT VETERINARIAN
        // ==============================
        $firstName = 'Jose';
        $lastName = 'Reyes';
        $contactNumber = '091988877704';

        $user4 = User::firstOrCreate(
            ['email' => 'assistantvet@vetmis.gov'],
            [
                'email' => 'assistantvet@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user4->assignRole('assistant_vet');
        Admin::firstOrCreate(
            ['user_id' => $user4->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role_type' => 'assistant_vet',
                'contact_number' => $contactNumber,
            ]
        );

        // ==============================
        // THESIS ROLE 5: LIVESTOCK INSPECTOR
        // ==============================
        $firstName = 'Roberto';
        $lastName = 'Gonzales';
        $contactNumber = '091988877705';

        $user5 = User::firstOrCreate(
            ['email' => 'livestock@vetmis.gov'],
            [
                'email' => 'livestock@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user5->assignRole('livestock_inspector');
        Admin::firstOrCreate(
            ['user_id' => $user5->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role_type' => 'livestock_inspector',
                'contact_number' => $contactNumber,
            ]
        );

        // ==============================
        // THESIS ROLE 6: MEAT INSPECTOR
        // ==============================
        $firstName = 'Pedro';
        $lastName = 'Martinez';
        $contactNumber = '091988877706';

        $user6 = User::firstOrCreate(
            ['email' => 'meatinspector@vetmis.gov'],
            [
                'email' => 'meatinspector@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user6->assignRole('meat_inspector');
        Admin::firstOrCreate(
            ['user_id' => $user6->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role_type' => 'meat_inspector',
                'contact_number' => $contactNumber,
            ]
        );

        // ==============================
        // THESIS ROLE 7: CITIZEN (PET OWNER)
        // ==============================
        $firstName = 'Juan';
        $lastName = 'dela Cruz';
        $contactNumber = '091988877707';

        $user7 = User::firstOrCreate(
            ['email' => 'citizen@test.com'],
            [
                'email' => 'citizen@test.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user7->assignRole('pet_owner');
        PetOwner::firstOrCreate(
            ['user_id' => $user7->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone_number' => $contactNumber,
            ]
        );

        // ==============================
        // ADDITIONAL ACCOUNTS
        // ==============================

        // Disease Control (alias for assistant_vet)
        $firstName = 'Miguel';
        $lastName = 'Torres';
        $contactNumber = '091988877708';

        $user8 = User::firstOrCreate(
            ['email' => 'diseasecontrol@vetmis.gov'],
            [
                'email' => 'diseasecontrol@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user8->assignRole('disease_control');
        // Map to assistant_vet for role_type since disease_control not in admins.role_type enum
        Admin::firstOrCreate(
            ['user_id' => $user8->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role_type' => 'assistant_vet',
                'contact_number' => $contactNumber,
            ]
        );

        // Admin Assistant
        $firstName = 'Lucia';
        $lastName = 'Fernandez';
        $contactNumber = '091988877709';

        $user9 = User::firstOrCreate(
            ['email' => 'adminasst@vetmis.gov'],
            [
                'email' => 'adminasst@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user9->assignRole('admin_asst');
        Admin::firstOrCreate(
            ['user_id' => $user9->id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role_type' => 'admin_asst',
                'contact_number' => $contactNumber,
            ]
        );

        // Vet Clinic
        $firstName = 'Happy Paws';
        $lastName = 'Veterinary Clinic';
        $contactNumber = '091988877710';

        $user10 = User::firstOrCreate(
            ['email' => 'clinic@vetmis.gov'],
            [
                'email' => 'clinic@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user10->assignRole('clinic');
        Organization::firstOrCreate(
            ['contact_user_id' => $user10->id],
            [
                'name' => $firstName.' '.$lastName,
                'type' => 'clinic',
                'contact_number' => $contactNumber,
                'official_email' => $user10->email,
                'is_active' => true,
            ]
        );

        // Vet Hospital
        $firstName = 'City Pet';
        $lastName = 'Hospital';
        $contactNumber = '091988877711';

        $user11 = User::firstOrCreate(
            ['email' => 'hospital@vetmis.gov'],
            [
                'email' => 'hospital@vetmis.gov',
                'password' => bcrypt('password123'),
                'status' => 'active',
            ]
        );
        $user11->assignRole('hospital');
        Organization::firstOrCreate(
            ['contact_user_id' => $user11->id],
            [
                'name' => $firstName.' '.$lastName,
                'type' => 'hospital',
                'contact_number' => $contactNumber,
                'official_email' => $user11->email,
                'is_active' => true,
            ]
        );

        // Print info
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('THESIS TEST ACCOUNTS CREATED');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('📋 ROLES:');
        $this->command->info('1. superadmin@vetmis.gov - Super Admin (password123)');
        $this->command->info('2. cityvet@vetmis.gov - City Veterinarian (password123)');
        $this->command->info('3. adminstaff@vetmis.gov - Admin Staff (password123)');
        $this->command->info('4. assistantvet@vetmis.gov - Assistant Vet (password123)');
        $this->command->info('5. livestock@vetmis.gov - Livestock Inspector (password123)');
        $this->command->info('6. meatinspector@vetmis.gov - Meat Inspector (password123)');
        $this->command->info('7. citizen@test.com - Pet Owner (password123)');
        $this->command->info('8. diseasecontrol@vetmis.gov - Disease Control (password123)');
        $this->command->info('9. adminasst@vetmis.gov - Admin Assistant (password123)');
        $this->command->info('10. clinic@vetmis.gov - Vet Clinic (password123)');
        $this->command->info('11. hospital@vetmis.gov - Vet Hospital (password123)');
        $this->command->info('');
    }
}
