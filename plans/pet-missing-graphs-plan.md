# Pet Adoption & Missing Pet Reports Graphs Plan

## Overview
Replace the static KPI card values for Pet Adoption Rate and Missing Pet Recovery with dual-line series graphs using Chart.js. The graphs will show 12-month trends using existing controller methods.

## Affected Area
- `resources/views/dashboard/city-vet.blade.php` - Chart canvas replacement
- `app/Http/Controllers/CityVetController.php` - Add new data methods if needed
- Chart.js configuration in the view

## Data Sources (Existing Controller Methods)

| Graph | Data Series | Controller Method | Description |
|-------|-------------|-------------------|-------------|
| **Pet Adoption Operational Volume** | Line 1 (Blue): Applications Submitted | `getMonthlyAdoptionByYear($year)` | `AdoptionApplication` count by month |
| | Line 2 (Green): Adopted Pets | `getMonthlyAdoptionStatusByYear($year, 'Adopted')` | AdoptionApplications with status = 'Adopted' by month |
| **Lost & Found Pet Reunification Volume** | Line 1 (Orange): Lost & Found Reports | `getMonthlyMissingByYear($year)` | `MissingPetsReport` count by month |
| | Line 2 (Dark Blue): Pets Reunited/Resolved | `getMonthlyMissingResolvedByYear($year)` | `MissingPetsReport` with status resolved by month |

## Required Changes

### 1. Controller: Add Data Methods (if not already available)
The following methods already exist in `CityVetController.php`:
- `getMonthlyAdoptionByYear($year)` - Line 539 ✓
- `getMonthlyAdoptionStatusByYear($year, 'Adopted')` - Line 556 ✓ (verify status value)
- `getMonthlyMissingByYear($year)` - Line 605 ✓
- `getMonthlyMissingResolvedByYear($year)` - Line 632 ✓

**Note**: Verify that the status value 'Adopted' exists in AdoptionApplication model. If not, may need to adjust status name.

### 2. View: Replace KPI Cards with Chart Canvases

**Pet Adoption Graph (Card 3 replacement):**
- Title: "Pet Adoption Operational Volume"
- X-Axis: Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec
- Y-Axis: dynamic (auto-scale based on data)
- Dataset 1: Blue line - "Applications Submitted" from `getMonthlyAdoptionByYear($year)`
- Dataset 2: Green line - "Adopted Pets" from `getMonthlyAdoptionStatusByYear($year, 'Adopted')`
- Chart container: Replace the Card 3 KPI card structure

**Missing Pet Graph (Card 4 replacement):**
- Title: "Lost & Found Pet Reunification Volume"
- X-Axis: Jan to Dec 12-month timeline
- Y-Axis: dynamic (auto-scale based on data)
- Dataset 1: Orange line - "Lost & Found Reports Filed" from `getMonthlyMissingByYear($year)`
- Dataset 2: Dark Blue line - "Pets Reunited/Resolved" from `getMonthlyMissingResolvedByYear($year)`
- Chart container: Replace the Card 4 KPI card structure

### 3. Chart.js Configuration

Both graphs use the same base configuration:
- `responsive: true`
- `maintainAspectRatio: false`
- `plugins: { legend: { display: true } }`
- `scales: { y: { beginAtZero: true, ticks: { stepSize: 5 } }, x: { grid: { display: false } } }`
- `plugins: { tooltip: { enabled: true } }`

### 4. View Integration

Replace the Card 3 and Card 4 KPI card HTML with Chart.js canvas elements:

**Pet Adoption Graph HTML:**
```html
<div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 h-full flex flex-col justify-between">
    <h5 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Pet Adoption Operational Volume</h5>
    <canvas id="petAdoptionChart"></canvas>
</div>
```

**Missing Pet Graph HTML:**
```html
<div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 h-full flex flex-col justify-between">
    <h5 class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-2">Lost & Found Pet Reunification Volume</h5>
    <canvas id="missingPetChart"></canvas>
</div>
```

**JavaScript Initialization:**
```javascript
// Pet Adoption Chart
const petAdoptionCtx = document.getElementById('petAdoptionChart').getContext('2d');
new Chart(petAdoptionCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'Applications Submitted',
                data: <?php echo json_encode($monthlyAdoptionData); ?>,
                borderColor: 'blue',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1
            },
            {
                label: 'Successful Adoptions',
                data: <?php echo json_encode($monthlyAdoptionStatusData); ?>,
                borderColor: 'green',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: { enabled: true }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 5 } },
            x: { grid: { display: false } }
        }
    }
});

// Missing Pet Chart
const missingPetCtx = document.getElementById('missingPetChart').getContext('2d');
new Chart(missingPetCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'Lost & Found Reports Filed',
                data: <?php echo json_encode($monthlyMissingData); ?>,
                borderColor: 'orange',
                backgroundColor: 'rgba(251, 191, 36, 0.1)',
                tension: 0.1
            },
            {
                label: 'Pets Reunited/Resolved',
                data: <?php echo json_encode($monthlyMissingResolvedData); ?>,
                borderColor: 'darkblue',
                backgroundColor: 'rgba(30, 64, 139, 0.1)',
                tension: 0.1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: { enabled: true }
        },
        scales: {
            beginAtZero: true, ticks: { stepSize: 5 },
            x: { grid: { display: false } }
        }
    }
);
```

### 5. Controller Data Preparation

Add these to the data passed to the view (in `dashboard()` method):

```php
// Pet Adoption Monthly Data
$monthlyAdoptionData = $this->getMonthlyAdoptionByYear($year);
$monthlyAdoptionStatusData = $this->getMonthlyAdoptionStatusByYear($year, 'Completed');

// Missing Pet Monthly Data
$monthlyMissingData = $this->getMonthlyMissingByYear($year);
$monthlyMissingResolvedData = $this->getMonthlyMissingResolvedByYear($year);
```

Add to the `compact()` call:
```php
'adoptionMonthlyData' => $monthlyAdoptionData,
'adoptionMonthlyStatusData' => $monthlyAdoptionStatusData,
'missingMonthlyData' => $monthlyMissingData,
'missingMonthlyResolvedData' => $missingMonthlyResolvedData,
```

### 6. Validation Plan
1. Navigate to `/city-vet/dashboard` with data in database
2. Verify Pet Adoption graph shows blue line (applications) and green line (adoptions) for all 12 months
3. Verify Missing Pet graph shows orange line (reports filed) and dark blue line (resolved cases) for all 12 months
4. Verify Y-axes are scaled 0-15 with stepSize 5
5. Verify legends show correct dataset labels
6. Test with no data year - graphs should show 0 values
7. Verify symmetrical layout with other KPI cards and Charts Section

### Risks & Considerations
- **Status value**: Verify 'Completed' is the correct status value in AdoptionApplication model. May need to check against existing statuses: 'pending_review', 'approved', 'rejected'
- **Missing Pet Statuses**: The `getMonthlyMissingResolvedByYear` method uses `['resolved - reunited', 'resolved - shelter intake']` - ensure this matches the required "Resolved" criteria
- **Y-Axis Max**: Set to 15 as specified; if data exceeds this, consider auto-scaling or clamping
- **Missing Data**: Ensure graphs display 0 values when no data exists for a given year
- **Chart.js Version**: Ensure compatibility with existing Chart.js version loaded via CDN

### Open Questions
1. Verify 'Adopted' status value exists in AdoptionApplication model - may need to check against actual statuses in the database
2. Y-Axis should be dynamic (not limited to fixed range) - will auto-scale based on data values
3. Keep existing CSS styling - no additional styling needed beyond current card design

### Success Criteria
1. Both graphs render with correct data from the controller methods
2. X-Axis shows 12 months (Jan-Dec) with proper labeling
3. Y-Axis auto-scales based on data range (no fixed maximum)
4. Two lines per graph with correct colors (Blue/Green for Adoption, Orange/DarkBlue for Missing Pet)
5. Legends display correct dataset labels
6. Graphs maintain responsive design and symmetrical layout with rest of dashboard
7. No JavaScript errors in console
8. Fallback to 0 displays correctly when no data exists for the selected year