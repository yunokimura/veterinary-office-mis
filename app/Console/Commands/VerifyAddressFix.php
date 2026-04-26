<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VerifyAddressFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:address-fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify that pet_owner addresses have city, province, and address_id populated';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Verifying Address Fix for Pet Owner Registration ==='.PHP_EOL);

        // Count pet_owners with NULL address_id
        $nullAddr = DB::table('pet_owners')->whereNull('address_id')->count();
        $this->line(sprintf('pet_owners with NULL address_id: %d', $nullAddr));

        // Count addresses with NULL city/province for pet_owners
        $nullCity = DB::table('addresses')
            ->whereIn('addressable_type', ['App\Models\PetOwner', 'pet_owner'])
            ->whereNull('city')
            ->count();
        $this->line(sprintf('pet_owner addresses with NULL city: %d', $nullCity));

        $nullProv = DB::table('addresses')
            ->whereIn('addressable_type', ['App\Models\PetOwner', 'pet_owner'])
            ->whereNull('province')
            ->count();
        $this->line(sprintf('pet_owner addresses with NULL province: %d', $nullProv));

        $this->line('');

        // Show recent 5 records
        $this->info('Recent 5 pet_owner address records:');
        $rows = DB::table('pet_owners')
            ->join('addresses', 'pet_owners.address_id', '=', 'addresses.id')
            ->select(
                'pet_owners.owner_id',
                'pet_owners.first_name',
                'pet_owners.last_name',
                'addresses.city',
                'addresses.province',
                'addresses.street'
            )
            ->orderBy('pet_owners.created_at', 'desc')
            ->limit(5)
            ->get();

        $this->table(
            ['ID', 'Name', 'City', 'Province', 'Street'],
            $rows->map(function ($r) {
                return [
                    $r->owner_id,
                    $r->first_name.' '.$r->last_name,
                    $r->city ?? 'NULL',
                    $r->province ?? 'NULL',
                    $r->street ?? 'NULL',
                ];
            })
        );

        $this->line('');

        // Determine overall status
        $hasIssues = ($nullAddr > 0 || $nullCity > 0 || $nullProv > 0);

        if ($hasIssues) {
            $this->error('FAILED: Some records still have NULL values.');

            return 1;
        } else {
            $this->info('SUCCESS: All pet_owner addresses have proper city, province, and address_id.');

            return 0;
        }
    }
}
