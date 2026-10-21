# KPI Chart Remodel Plan: Rabies Cases vs Vaccinations per Barangay

## Overview
Rebuild the "Confirmed Rabies Cases vs Vaccinations per Barangay" chart into a full-width stacked/grouped bar chart showing top barangays by month with filter controls for Year and Barangay multi-select. Rearrange remaining charts below.

## Affected Files
- `resources/views/dashboard/city-vet.blade.php` - Chart HTML structure, filter controls, Chart.js config
- `app/Http/Controllers/CityVetController.php` - Add data endpoints for top barangays by month

## Data Requirements

### Backend Data Needed
From the controller:
1. **Year dropdown**: Available years from `bite_rabies_reports` and `vaccination_reports` tables
2. **Barangay list**: All barangays for multi-select dropdown
3. **Chart data**: For selected year and selected barangays:
   - Monthly data (Jan-Dec) for each barangay showing bite cases vs vaccinations
   - Top N barangays by total cases (top 5 or top 10)
   - All other barangays aggregated into "Others" category

### Chart Data Structure
```json
{
  "labels": ["Jan", "Feb", ..., "Dec"],
  "datasets": [
    { "label": "Barangay A - Cases", "data": [..12 months..], "backgroundColor": "...", "stack": "cases" },
    { "label": "Barangay A - Vaccinations", "data": [..12 months..], "backgroundColor": "...", "stack": "vacc" },
    { "label": "Others - Cases", "data": [..12 months..], "backgroundColor": "...", "stack": "cases" },
    { "label": "Others - Vaccinations", "data": [..12 months..], "backgroundColor": "...", "stack": "vacc" }
  ]
}
```

## Layout Changes

### Current Layout (2-column grid)
```
Row 1: [Chart 1: Rabies vs Vaccinations] [Chart 2: Spay/Neuter]
Row 2: [Chart 3: Pet Adoption]          [Chart 4: Missing Pet Reports]
```

### New Layout
```
Row 1: [Chart 1: Rabies vs Vaccinations - FULL WIDTH]
Row 2: [Chart 2: Spay/Neuter] [Chart 3: Pet Adoption] [Chart 4: Missing Pet Reports]
```

### Filter Controls (Above Chart 1)
- Year Dropdown (default: current year)
- Barangay Multi-Select (default: All Barangays)

## Implementation Steps

### Step 1: Update CityVetController
Add data methods for:
- Available years for year dropdown
- All barangays for multi-select
- Chart data endpoint: monthly bite cases vs vaccinations per selected barangays

### Step 2: Update View Layout
Replace `<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">` with:
- Row 1: Full-width div for Chart 1
- Row 2: 3-column grid for remaining charts

### Step 3: Add Filter Controls
Add Year dropdown + Barangay multi-select above Chart 1

### Step 4: Update Chart.js Configuration
Change from clustered bar per barangay to:
- Stacked/grouped bar per month
- Each barangay = 2 datasets (cases + vaccinations)
- Colors consistent per barangay
- Legend showing barangay names

## Filter Logic
- **Year dropdown**: Filters both bite cases and vaccinations by year
- **Barangay multi-select**: 
  - "All Barangays" (default): Shows top N barangays by total cases
  - Specific selection: Shows only selected barangays (max 10 for readability)

## Success Criteria
- Chart 1 spans full width of page
- X-axis shows Jan-Dec months
- Y-axis shows case counts
- Top N barangays stacked/grouped, others aggregated
- Filter controls update chart data on change
- Remaining charts (Spay/Neuter, Pet Adoption, Missing Pet) arranged in second row
- Symmetrical styling consistent with KPI cards above