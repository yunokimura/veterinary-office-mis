<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * Shared logic for deriving a human-readable pet age string from a birthdate.
 *
 * Format: "X years Y months", e.g. "2 years 3 months", "0 months".
 * Returns null when no valid birthdate is available.
 */
class PetAge
{
    /**
     * Compute the age string for the given birthdate.
     *
     * @param  Carbon|string|null  $birthdate
     */
    public static function compute($birthdate): ?string
    {
        if (! $birthdate) {
            return null;
        }

        try {
            $birth = $birthdate instanceof Carbon
                ? $birthdate->copy()
                : Carbon::parse($birthdate);
        } catch (\Throwable $e) {
            return null;
        }

        // Guard against MySQL zero-dates ("0000-00-00") and other invalid values.
        if (($birth->year ?? 0) < 1) {
            return null;
        }

        $now = now();
        $years = (int) $birth->diffInYears($now);
        $months = (int) $birth->copy()->addYears($years)->diffInMonths($now);

        $parts = [];
        if ($years > 0) {
            $parts[] = $years.' year'.($years > 1 ? 's' : '');
        }
        if ($months > 0) {
            $parts[] = $months.' month'.($months > 1 ? 's' : '');
        }

        return $parts ? implode(' ', $parts) : '0 months';
    }
}
