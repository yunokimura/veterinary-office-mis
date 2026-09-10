<?php

namespace App\Helpers;

use Carbon\Carbon;

class LogSearchParser
{
    /**
     * Supported date/time formats in priority order.
     *
     * @var string[]
     */
    private static array $dateFormats = [
        // DD/MM/YYYY and variants (priority)
        'd/m/Y',
        'd-m-Y',
        'd/m/y',
        'd-m-y',
        // YYYY-MM-DD and variants
        'Y-m-d',
        'Y/m/d',
        'y-m-d',
        'y/m/d',
        // Written dates
        'F j, Y',
        'F j,Y',
        'F j Y',
        'M j, Y',
        'M j,Y',
        'M j Y',
        // Combined date + time
        'd/m/Y H:i',
        'd/m/Y H:i:s',
        'd-m-Y H:i',
        'd-m-Y H:i:s',
        'Y-m-d H:i',
        'Y-m-d H:i:s',
        'Y/m/d H:i',
        'Y/m/d H:i:s',
        'F j, Y g:i A',
        'F j, Y g:i:s A',
        'M j, Y g:i A',
        'M j, Y g:i:s A',
        // Time only
        'H:i',
        'H:i:s',
        'g:i A',
        'g:i:s A',
        'G:i',
        'G:i:s',
    ];

    /**
     * Parse a single search term and return date/time info if it matches.
     *
     * @return array{type: 'datetime'|'date'|'time'|'year'|null, date: Carbon|null, time: Carbon|null, value: Carbon|null}
     */
    public static function parseSearchTerm(string $search): array
    {
        $trimmed = trim($search);

        if ($trimmed === '') {
            return ['type' => null, 'date' => null, 'time' => null, 'value' => null];
        }

        // Year-only: exactly 4 digits
        if (preg_match('/^\d{4}$/', $trimmed)) {
            $year = (int) $trimmed;
            if ($year >= 1900 && $year <= 2100) {
                return ['type' => 'year', 'date' => null, 'time' => null, 'value' => Carbon::create($year, 1, 1)];
            }
        }

        // Try explicit formats first, then Carbon::parse as fallback
        $carbon = self::tryParse($trimmed);

        if (!$carbon) {
            return ['type' => null, 'date' => null, 'time' => null, 'value' => null];
        }

        // Determine if the original term looks like it includes time
        $hasTime = (bool) preg_match('/\d{1,2}:\d{2}/', $trimmed);
        $hasAmPm = (bool) preg_match('/\b(AM|PM|am|pm)\b/', $trimmed);

        if ($hasTime || $hasAmPm) {
            return ['type' => 'datetime', 'date' => $carbon, 'time' => $carbon, 'value' => $carbon];
        }

        // If it parsed as a recognizable date (not just "now"), treat as date
        return ['type' => 'date', 'date' => $carbon, 'time' => null, 'value' => $carbon];
    }

    /**
     * Check if a term should be treated as date/time search.
     */
    public static function isDateTimeSearch(string $search): bool
    {
        $result = self::parseSearchTerm($search);

        return $result['type'] !== null;
    }

    /**
     * Split a search string by spaces and parse each term.
     *
     * @return array{dateTerms: array<int, array>, textTerms: array<int, string>}
     */
    public static function parseSearchTerms(string $search): array
    {
        $terms = preg_split('/\s+/', trim($search), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $dateTerms = [];
        $textTerms = [];

        foreach ($terms as $term) {
            $parsed = self::parseSearchTerm($term);
            if ($parsed['type'] !== null) {
                $dateTerms[] = $parsed;
            } else {
                $textTerms[] = $term;
            }
        }

        return ['dateTerms' => $dateTerms, 'textTerms' => $textTerms];
    }

    /**
     * Try to parse a string against known formats, then fall back to Carbon::parse.
     */
    private static function tryParse(string $value): ?Carbon
    {
        // Avoid parsing pure text that Carbon might misinterpret
        if (preg_match('/^[a-zA-Z]+$/i', $value)) {
            return null;
        }

        foreach (self::$dateFormats as $format) {
            try {
                $carbon = Carbon::createFromFormat($format, $value);
                if ($carbon && $carbon->year >= 1900 && $carbon->year <= 2100) {
                    return $carbon;
                }
            } catch (\Exception $e) {
                // Try next format
            }
        }

        // Fallback to Carbon::parse for natural language like "last week", "today", etc.
        try {
            $carbon = Carbon::parse($value);
            if ($carbon && $carbon->year >= 1900 && $carbon->year <= 2100) {
                return $carbon;
            }
        } catch (\Exception $e) {
            // Ignore
        }

        return null;
    }
}
