<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\PetOwner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixPetOwnerAddressId extends Command
{
    protected $signature = 'pet-owners:fix-address-id';

    protected $description = 'Link pet_owners to their addresses via address_id';

    public function handle()
    {
        $this->info('Fixing pet_owners address_id...');

        $updated = 0;
        $missing = 0;

        $petOwners = PetOwner::all(); // all pet_owners

        foreach ($petOwners as $po) {
            $address = Address::where('addressable_type', 'pet_owner')
                ->where('addressable_id', $po->owner_id)
                ->first();
            if ($address) {
                DB::table('pet_owners')
                    ->where('owner_id', $po->owner_id)
                    ->update(['address_id' => $address->id]);
                $updated++;
                $this->line("  Set address_id {$address->id} for pet_owner {$po->owner_id}");
            } else {
                $missing++;
                $this->warn("  No address found for pet_owner {$po->owner_id}");
            }
        }

        $this->info("Done. Updated: {$updated}, Missing addresses: {$missing}");

        return 0;
    }
}
