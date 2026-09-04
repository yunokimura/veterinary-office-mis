<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignSpatieRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        $roles = ['super_admin', 'city_vet', 'admin_asst', 'assistant_vet',
            'meat_inspector', 'pet_owner'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Map legacy role column to Spatie roles (using accessor for backward compatibility)
        $users = User::whereDoesntHave('roles')->get();

        $roleMapping = [
            'super_admin' => 'super_admin',
            'city_vet' => 'city_vet',
            'admin' => 'city_vet',
            'admin_asst' => 'admin_asst',
            'assistant_vet' => 'assistant_vet',
            'meat_inspector' => 'meat_inspector',
            'pet_owner' => 'pet_owner',
        ];

        foreach ($users as $user) {
            // Read legacy role column directly
            $currentRole = $user->role;
            $spatieRole = $roleMapping[$currentRole] ?? 'pet_owner';

            // Remove existing roles and assign new one
            $user->syncRoles($spatieRole);

            $this->command->info("Assigned '{$spatieRole}' to user {$user->email} (was: {$currentRole})");
        }

        $this->command->info('Role migration complete!');
    }
}
