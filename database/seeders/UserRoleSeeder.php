<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates sample users for each role with access to their dashboards
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'superadmin@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567890',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'cityvet@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567891',
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'adminasst@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567892',
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Garcia',
                'email' => 'veterinarian@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567893',
            ],
            [
                'first_name' => 'Paws Animal',
                'last_name' => 'Clinic',
                'email' => 'clinic@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567890',
            ],
            [
                'first_name' => 'Roberto',
                'last_name' => 'Cruz',
                'email' => 'livestock@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567894',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Lopez',
                'email' => 'meatinspector@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567895',
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Miller',
                'email' => 'records@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567896',
            ],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Reyes',
                'email' => 'diseasecontrol@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567897',
            ],
            [
                'first_name' => 'Barangay',
                'last_name' => 'Encoder',
                'email' => 'barangay@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567898',
            ],
            [
                'first_name' => 'Supervisor',
                'last_name' => 'User',
                'email' => 'viewer@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'contact_number' => '091234567899',
            ],
        ];

        foreach ($users as $userData) {
            $existingUser = User::where('email', $userData['email'])->first();
            
            if (!$existingUser) {
                User::create($userData);
                echo "Created user: {$userData['email']}\n";
            } else {
                $existingUser->update([
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'status' => 'active',
                ]);
                echo "Updated user: {$userData['email']}\n";
            }
        }
    }
}
