<?php

namespace App\Observers;

use App\Models\PetInfo;
use App\Models\SpayNeuterAppointment;

class SpayNeuterAppointmentObserver
{
    public function updated(SpayNeuterAppointment $appointment): void
    {
        if ($appointment->isDirty('status') && $appointment->status === 'completed') {
            PetInfo::where('pet_id', $appointment->pet_id)->update(['is_neutered' => 'yes']);
        }
    }
}
