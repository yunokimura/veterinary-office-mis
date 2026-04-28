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
                'email' => 'superadmin@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'cityvet@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'adminasst@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'veterinarian@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'clinic@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'livestock@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'meatinspector@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'records@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'diseasecontrol@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'barangay@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'email' => 'viewer@vetmis.gov',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
        ];

        foreach ($users as $userData) {
            $existingUser = User::where('email', $userData['email'])->first();

            if (! $existingUser) {
                User::create($userData);
                echo "Created user: {$userData['email']}\n";
            } else {
                $existingUser->update([
                    'status' => 'active',
                ]);
                echo "Updated user: {$userData['email']}\n";
            }
        }
    }
}
