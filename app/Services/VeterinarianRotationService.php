<?php

namespace App\Services;

use App\Models\SpayNeuterAppointment;
use App\Models\SpayNeuterReport;
use Illuminate\Support\Facades\DB;

class VeterinarianRotationService
{
    /**
     * Assign the next veterinarian based on rotation.
     *
     * Alternates between 'City Veterinarian' and 'Assistant Veterinarian'
     * based on the most recently assigned veterinarian.
     *
     * Kapon bookings are stored in `spay_neuter_appointments`; `spay_neuter_reports`
     * is still consulted so legacy and manually entered reports keep influencing
     * the rotation.
     *
     * Uses database locking to prevent race conditions during concurrent bookings.
     *
     * @return string 'City Veterinarian' or 'Assistant Veterinarian'
     */
    public function assignVeterinarian(): string
    {
        return DB::transaction(function () {
            $veterinarians = [
                'City Veterinarian',
                'Assistant Veterinarian',
            ];

            $lastAppointment = SpayNeuterAppointment::whereIn('veterinarian', $veterinarians)
                ->whereNotNull('veterinarian')
                ->orderBy('scheduled_at', 'desc')
                ->lockForUpdate()
                ->first();

            $lastReport = SpayNeuterReport::whereIn('veterinarian', $veterinarians)
                ->whereNotNull('veterinarian')
                ->orderBy('scheduled_at', 'desc')
                ->lockForUpdate()
                ->first();

            // Whichever of the two was scheduled most recently wins.
            $last = collect([$lastAppointment, $lastReport])
                ->filter()
                ->sortByDesc(fn ($record) => optional($record->scheduled_at)->getTimestamp() ?? 0)
                ->first();

            // If no previous assignment exists, start with City Veterinarian
            if (! $last) {
                return 'City Veterinarian';
            }

            // Alternate: City -> Assistant -> City -> ...
            return $last->veterinarian === 'City Veterinarian'
                ? 'Assistant Veterinarian'
                : 'City Veterinarian';
        });
    }
}
