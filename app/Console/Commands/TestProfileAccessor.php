<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TestProfileAccessor extends Command
{
    protected $signature = 'test:profile-accessor';

    protected $description = 'Test User profile accessor after normalization';

    public function handle()
    {
        $this->info('=== Admin Profiles ===');
        $adminUsers = User::whereHas('roles', fn ($q) => $q->whereIn('name', [
            'super_admin', 'city_vet', 'admin_staff', 'admin_asst', 'assistant_vet', 'livestock_inspector', 'meat_inspector',
        ]))->with(['adminProfile', 'petOwnerProfile', 'organizationProfile'])->take(3)->get();

        foreach ($adminUsers as $user) {
            $this->info("User: {$user->email}");
            $this->line("  Name: {$user->first_name} {$user->last_name}");
            $this->line("  Role: {$user->role}");
            $this->line('  Profile: '.($user->profile ? get_class($user->profile) : 'NULL'));
            $this->line("  Contact: {$user->contact_number}");
            $this->newLine();
        }

        $this->info('=== Pet Owner Profiles ===');
        $petOwnerUsers = User::whereHas('roles', fn ($q) => $q->where('name', 'pet_owner'))
            ->with(['petOwnerProfile'])
            ->take(3)->get();

        foreach ($petOwnerUsers as $user) {
            $this->info("User: {$user->email}");
            $this->line("  Name: {$user->first_name} {$user->last_name}");
            $this->line("  Role: {$user->role}");
            $this->line('  Profile: '.($user->profile ? get_class($user->profile) : 'NULL'));
            $this->line("  Contact: {$user->contact_number}");
            if ($user->petOwnerProfile) {
                $this->line("  PetOwner phone: {$user->petOwnerProfile->phone_number}");
                $this->line("  Address ID: {$user->petOwnerProfile->address_id}");
            }
            $this->newLine();
        }

        $this->info('=== Organization Profiles ===');
        $orgUsers = User::whereHas('roles', fn ($q) => $q->whereIn('name', ['clinic', 'hospital']))
            ->with(['organizationProfile'])
            ->take(3)->get();

        foreach ($orgUsers as $user) {
            $this->info("User: {$user->email}");
            $this->line("  Name: {$user->first_name}");
            $this->line("  Role: {$user->role}");
            $this->line('  Profile: '.($user->profile ? get_class($user->profile) : 'NULL'));
            if ($user->organizationProfile) {
                $this->line("  Org Name: {$user->organizationProfile->name}");
                $this->line("  Contact #: {$user->organizationProfile->contact_number}");
            }
            $this->newLine();
        }

        return 0;
    }
}
