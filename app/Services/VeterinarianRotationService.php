<?php

namespace App\Services;

use App\Models\SpayNeuterReport;
use Illuminate\Support\Facades\DB;

class VeterinarianRotationService
{
    /**
     * Assign the next veterinarian based on rotation.
     *
     * Alternates between 'City Veterinarian' and 'Assistant Veterinarian'
     * based on the most recently assigned veterinarian for a scheduled report.
     *
     * Uses database locking to prevent race conditions during concurrent bookings.
     *
     * @return string 'City Veterinarian' or 'Assistant Veterinarian'
     */
    public function assignVeterinarian(): string
    {
        return DB::transaction(function () {
            // Lock the most recent record with a veterinarian assignment
            $last = SpayNeuterReport::whereIn('veterinarian', [
                'City Veterinarian',
                'Assistant Veterinarian',
            ])
                ->whereNotNull('veterinarian')
                ->orderBy('scheduled_at', 'desc')
                ->lockForUpdate()
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
