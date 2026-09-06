<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpatieRoleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roles = [
            // Primary roles
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'display_name' => 'Super Administrator',
                'description' => 'Full system access',
                'hierarchy_level' => 10,
            ],
            [
                'name' => 'city_vet',
                'guard_name' => 'web',
                'display_name' => 'City Veterinarian',
                'description' => 'Admin/office head access',
                'hierarchy_level' => 8,
            ],
            [
                'name' => 'assistant_vet',
                'guard_name' => 'web',
                'display_name' => 'Assistant Veterinarian',
                'description' => 'Assistant vet access',
                'hierarchy_level' => 5,
            ],
            [
                'name' => 'admin_asst',
                'guard_name' => 'web',
                'display_name' => 'Administrative Assistant',
                'description' => 'Admin assistant access',
                'hierarchy_level' => 5,
            ],
            [
                'name' => 'meat_inspector',
                'guard_name' => 'web',
                'display_name' => 'Meat Inspector',
                'description' => 'Meat inspection access',
                'hierarchy_level' => 4,
            ],
            [
                'name' => 'pet_owner',
                'guard_name' => 'web',
                'display_name' => 'Pet Owner',
                'description' => 'Pet owner / citizen portal',
                'hierarchy_level' => 1,
            ],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::updateOrCreate(
                ['name' => $role['name'], 'guard_name' => $role['guard_name']],
                $role
            );
        }

        $firstAdmin = User::orderBy('id', 'asc')->first();

        if ($firstAdmin) {
            $roleMapping = [
                'super_admin' => 'super_admin',
                'city_vet' => 'city_vet',
                                'admin_asst' => 'admin_asst',
                'assistant_vet' => 'assistant_vet',
                'meat_inspector' => 'meat_inspector',
                'pet_owner' => 'pet_owner',
            ];

            $existingRole = $firstAdmin->getRoleNames()->first();
            $spatieRole = $roleMapping[$existingRole] ?? 'admin_asst';

            $firstAdmin->assignRole($spatieRole);

            $this->command->info("Assigned '{$spatieRole}' role to first admin (ID: {$firstAdmin->id})");
        } else {
            $this->command->warn('No admin users found. Please create an admin user first.');
        }
    }
}
