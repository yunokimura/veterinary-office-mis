<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = $this->getPermissions();
        $rolePermissions = $this->getRolePermissions();

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo(Permission::all());
        }

        $roleMappings = [
            'city_vet' => Role::where('name', 'city_vet')->first(),
            'assistant_vet' => Role::where('name', 'assistant_vet')->first(),
            'admin_asst' => Role::where('name', 'admin_asst')->first(),
            'meat_inspector' => Role::where('name', 'meat_inspector')->first(),
            'pet_owner' => Role::where('name', 'pet_owner')->first(),
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = $roleMappings[$roleName] ?? null;
            if ($role && !empty($permissions)) {
                $role->givePermissionTo($permissions);
            }
        }
    }

    private function getPermissions(): array
    {
        return [
            // Dashboard
            'dashboard.access',

            // User Management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.toggle-status',
            'users.change-role',

            // Announcements
            'announcements.view',
            'announcements.create',
            'announcements.edit',
            'announcements.delete',

            // System
            'system-logs.view',
            'system-logs.export',
            'settings.view',
            'settings.edit',

            // Rabies Cases
            'rabies-cases.view',
            'rabies-cases.create',
            'rabies-cases.edit',
            'rabies-cases.delete',

            // Spay-Neuter
            'spay-neuter.view',
            'spay-neuter.create',
            'spay-neuter.edit',
            'spay-neuter.delete',

            // Inventory
            'inventory.view',
            'inventory.create',
            'inventory.edit',
            'inventory.delete',

            // Livestock Census
            'livestock-census.view',
            'livestock-census.create',
            'livestock-census.edit',
            'livestock-census.delete',

            // Reports
            'reports.view',
            'reports.export',

            // Vaccination Reports
            'vaccination-reports.view',
            'vaccination-reports.create',

            // Bite Reports
            'bite-reports.view',
            'bite-reports.create',

            // Vaccination Records (assistant_vet)
            'vaccination-records.view',
            'vaccination-records.create',

            // Missing Pet Reports
            'missing-pet-reports.view',

            // Adoption Reports
            'adoption-reports.view',

            // Meat Inspection Reports
            'meat-inspection-reports.view',
            'meat-inspection-reports.create',
            'meat-inspection-reports.edit',

            // Meat Shop Inspections
            'meat-shop-inspections.view',
            'meat-shop-inspections.create',
            'meat-shop-inspections.edit',

            // Establishments
            'establishments.view',
            'establishments.create',
            'establishments.edit',

            // Pet Registrations
            'pet-registrations.view',
            'pet-registrations.create',
            'pet-registrations.edit',
            'pet-registrations.delete',

            // Missing Pets
            'missing-pets.view',
            'missing-pets.create',
            'missing-pets.edit',

            // Appointments
            'appointments.view',
            'appointments.approve',
            'appointments.reject',
            'appointments.complete',
            'appointments.reset',

            // Owner Reports
            'owner-reports.view',

            // Medical Records
            'medical-records.view',
            'medical-records.create',
            'medical-records.edit',
            'medical-records.delete',

            // Pets (pet_owner)
            'pets.view',
            'pets.edit',
            'pets.delete',

            // Profile (pet_owner)
            'profile.view',
            'profile.edit',
            'profile.delete',
        ];
    }

    private function getRolePermissions(): array
    {
        return [
            'city_vet' => [
                'dashboard.access',
                'users.view',
                'users.create',
                'users.edit',
                'users.toggle-status',
                'announcements.view',
                'announcements.create',
                'announcements.edit',
                'announcements.delete',
                'system-logs.view',
                'system-logs.export',
                'settings.view',
                'settings.edit',
                'rabies-cases.view',
                'rabies-cases.create',
                'rabies-cases.edit',
                'rabies-cases.delete',
                'spay-neuter.view',
                'spay-neuter.create',
                'spay-neuter.edit',
                'spay-neuter.delete',
                'inventory.view',
                'inventory.create',
                'inventory.edit',
                'inventory.delete',
                'livestock-census.view',
                'livestock-census.create',
                'livestock-census.edit',
                'livestock-census.delete',
                'reports.view',
                'reports.export',
                'vaccination-reports.view',
                'vaccination-reports.create',
                'bite-reports.view',
                'bite-reports.create',
                'missing-pet-reports.view',
                'adoption-reports.view',
                'meat-inspection-reports.view',
            ],
            'assistant_vet' => [
                'dashboard.access',
                'rabies-cases.view',
                'rabies-cases.create',
                'rabies-cases.edit',
                'rabies-cases.delete',
                'spay-neuter.view',
                'spay-neuter.create',
                'spay-neuter.edit',
                'spay-neuter.delete',
                'inventory.view',
                'inventory.create',
                'inventory.edit',
                'inventory.delete',
                'livestock-census.view',
                'livestock-census.create',
                'livestock-census.edit',
                'livestock-census.delete',
                'bite-reports.view',
                'bite-reports.create',
                'vaccination-reports.view',
                'vaccination-reports.create',
                'vaccination-records.view',
                'vaccination-records.create',
                'medical-records.view',
                'medical-records.create',
                'medical-records.edit',
                'medical-records.delete',
            ],
            'admin_asst' => [
                'dashboard.access',
                'pet-registrations.view',
                'pet-registrations.create',
                'pet-registrations.edit',
                'pet-registrations.delete',
                'missing-pets.view',
                'missing-pets.create',
                'missing-pets.edit',
                'appointments.view',
                'appointments.approve',
                'appointments.reject',
                'appointments.complete',
                'appointments.reset',
                'adoption-reports.view',
                'owner-reports.view',
                'inventory.view',
                'inventory.create',
                'inventory.edit',
                'inventory.delete',
            ],
            'meat_inspector' => [
                'dashboard.access',
                'meat-inspection-reports.view',
                'meat-inspection-reports.create',
                'meat-inspection-reports.edit',
                'meat-shop-inspections.view',
                'meat-shop-inspections.create',
                'meat-shop-inspections.edit',
                'establishments.view',
                'establishments.create',
                'establishments.edit',
            ],
            'pet_owner' => [
                'dashboard.access',
                'pets.view',
                'pets.edit',
                'pets.delete',
                'bite-reports.create',
                'profile.view',
                'profile.edit',
                'profile.delete',
            ],
        ];
    }
}
