<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateRecordsStaffUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'records@vetmis.gov.ph'],
            [
                'first_name' => 'Records',
                'last_name' => 'Staff',
                'password' => bcrypt('staff123'),
                'contact_number' => '09123456810',
                'address' => 'City Veterinary Office',
                'status' => 'active',
            ]
        );
        
        $this->command->info('Records Staff user created successfully!');
    }
}
