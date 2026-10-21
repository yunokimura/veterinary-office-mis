# KPI Cards Dynamic Data Integration Plan

## Overview
Integrate dynamic database values from the CityVetController into the KPI cards, replacing hardcoded values with data from the `$stats` array passed from the controller.

## Affected Area
- `resources/views/dashboard/city-vet.blade.php` - KPI cards display
- `app/Http/Controllers/CityVetController.php` - Data already available in `$stats`

## Data Source Mapping

The controller already passes the required data via the `$stats` array:

| KPI Card | Data Source (from `$stats`) | Current Hardcoded Value |
|----------|---------------------------|----------------------|
| **1. Rabies Cases** | `confirmed_bite_cases` (BiteRabiesReport) | `30` |
| **2. Anti-Rabies Vaccination** | `anti_rabies_vaccinations` (VaccinationReport) | `0.2%` |
| **3. Pet Adoption Rate** | `adoption_reports` (AdoptionApplication) | `0%` |
| **4. Missing Pet Recovery** | `missing_pet_reports` (MissingPetsReport) | `0%` |

## Implementation Plan

### Step 1: Update KPI Card 1 - Rabies Cases
**File**: `resources/views/dashboard/city-vet.blade.php` (line 32-58)
- Change: `<span class="text-4xl font-extrabold text-slate-900 tracking-tight">30</span>`
- To: `<span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $stats['confirmed_bite_cases'] ?? 0 }}</span>`

### Step 2: Update KPI Card 2 - Anti-Rabies Vaccination Performance
**File**: `resources/views/dashboard/city-vet.blade.php` (line 60-80)
- Change: The vaccination percentage display
- To: Display `$stats['anti_rabies_vaccinations']` with `%` symbol: `<span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $stats['anti_rabies_vaccinations'] ?? 0 }}%</span>`

### Step 3: Update KPI Card 3 - Pet Adoption Rate
**File**: `resources/views/dashboard/city-vet.blade.php` (line 82-101)
- Change: `<span class="text-4xl font-extrabold text-slate-900 tracking-tight">0%</span>`
- To: `<span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $stats['adoption_reports'] ?? 0 }}%</span>`

### Step 4: Update KPI Card 4 - Missing Pet Recovery
**File**: `resources/views/dashboard/city-vet.blade.php` (line 117-140)
- Change: `<span class="text-4xl font-extrabold text-slate-900 tracking-tight">0%</span>`
- To: `<span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $stats['missing_pet_reports'] ?? 0 }}%</span>`

### Step 5: Verify Data Flow
- Ensure `$stats` is passed to the view (already done at line 286 of Controller)
- Verify all 4 KPI cards render with dynamic values from the database
- Test with different years to ensure data consistency

### Step 6: Validation
- Confirm all 4 KPI cards display actual database values
- Verify the symmetrical alignment structure is maintained
- Check that fallback values (`?? 0`) work when no data exists

## Open Questions - RESOLVED

1. **Vaccination percentage `%` symbol**: YES - should include `%` symbol (user confirmed: "it should include a % symbol")
   - Implementation: Add `%` after the dynamic value: `{{ $stats['anti_rabies_vaccinations'] ?? 0 }}%`

2. **Other cards display format**: Keep as is (user confirmed: "No, keep them as is")
   - Implementation: Just add `%` to the vaccination card, keep adoption and missing pet reports unchanged in format

## Risks & Considerations
- The `$stats` array is already populated in the controller, no additional queries needed
- Fallback values (`?? 0`) ensure cards don't break if data is missing
- The symmetrical alignment structure (h-10, flex-1, border-b, etc.) must be preserved
- All cards use the same year filter (`$year = $request->year ?? date('Y')`)

## Success Criteria
- All 4 KPI cards display actual database values from their respective tables
- Card 1 shows total confirmed bite rabies cases from `bite_rabies_reports`
- Card 2 shows total anti-rabies vaccinations from `vaccination_reports` with `%` symbol
- Card 3 shows total adoption applications from `adoption_applications`
- Card 4 shows total missing pet reports from `missing_pets_reports`
- Symmetrical card layout maintained (h-full flex flex-col justify-between, h-10 headers, border-b dividers)
- Fallback to 0 when no data exists

## Implementation Task List

1. Edit Card 1: Replace hardcoded `30` with `{{ $stats['confirmed_bite_cases'] ?? 0 }}`
2. Edit Card 2: Replace hardcoded `0.2%` with `{{ $stats['anti_rabies_vaccinations'] ?? 0 }}%` (add `%` symbol)
3. Edit Card 3: Replace hardcoded `0%` with `{{ $stats['adoption_reports'] ?? 0 }}%`
4. Edit Card 4: Replace hardcoded `0%` with `{{ $stats['missing_pet_reports'] ?? 0 }}%`
5. Test the dashboard to verify dynamic data rendering
6. Verify alignment and spacing remain consistent
7. Run any existing tests to ensure no regressions

## Data Flow Verification

The controller already passes all required data:

```php
$stats = [
    'confirmed_bite_cases' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
    'anti_rabies_vaccinations' => VaccinationReport::whereYear('vaccination_date', $year)->count(),
    'adoption_reports' => \App\Models\AdoptionApplication::whereYear('created_at', $year)->count(),
    'missing_pet_reports' => \App\Models\MissingPetsReport::whereYear('created_at', $year)->count(),
];
```

These are passed to the view via:
```php
return view('dashboard.city-vet', compact(
    'user',
    'stats',
    // ... other data
));
```

The view currently uses `compact()` which extracts the `$stats` array making all keys available as variables in the Blade template.

## Validation Plan

1. Navigate to `/city-vet/dashboard` with data in the database
2. Verify Card 1 shows actual bite rabies case count
3. Verify Card 2 shows actual vaccination count with `%` symbol
4. Verify Card 3 shows actual adoption application count with `%` symbol
5. Verify Card 4 shows actual missing pet report count with `%` symbol
6. Test with no data (edge case) - should show 0
7. Verify symmetrical layout is intact across all screen sizes