<?php

namespace App\Observers;

use App\Models\AdoptionApplication;
use App\Models\Pet;

class AdoptionApplicationObserver
{
    public function updated(AdoptionApplication $application): void
    {
        if ($application->isDirty('status') && $application->status === 'adopted') {
            if ($application->selected_pet_id) {
                Pet::where('pet_id', $application->selected_pet_id)->update(['pet_status' => 'adopted']);
            }
        }
    }
}
