# Plan: Resolution Rate Over Time → Active vs Resolved Confirmed Rabies Cases

## Objective
Replace the current Resolution Rate percentage chart with a dual-line count chart matching the super-admin `System Activity Overview` style, showing **Active** vs **Resolved** confirmed rabies cases over time.

---

## 1. Controller Changes (`app/Http/Controllers/CityVetController.php`)

### 1.1 Replace Resolution Rate Helpers
- **Remove** `getMonthlyResolutionRate()` and `getYearlyResolutionRate()` from the resolution pipeline, or keep them but stop using them for this chart.
- **Add** new helpers:
  - `getMonthlyActiveVsResolved(int $year): array`
    - Returns `['Jan' => ['active' => N, 'resolved' => N], ...]`
    - Active = `rabies_confirmed = true` AND `status NOT IN ('Resolved', 'Closed')`
    - Resolved = `rabies_confirmed = true` AND `status IN ('Resolved', 'Closed')`
    - Months with zero records for **both** active and resolved return `null` (blank).
  - `getYearlyActiveVsResolved(): array`
    - Returns `[2024 => ['active' => N, 'resolved' => N], ...]`

### 1.2 Update `dashboard()`
- Stop computing `$avgResolutionRate` as a percentage.
- Compute:
  - `$totalActive = BiteRabiesReport::where('rabies_confirmed', true)->whereNotIn('status', ['Resolved', 'Closed'])->count();`
  - `$totalResolved = BiteRabiesReport::where('rabies_confirmed', true)->whereIn('status', ['Resolved', 'Closed'])->count();`
- Pass to view:
  - `resolutionActiveData` (monthly active counts)
  - `resolutionResolvedData` (monthly resolved counts)
  - `yearlyResolutionActiveData`
  - `yearlyResolutionResolvedData`
  - `compareResolutionActiveData`
  - `compareResolutionResolvedData`
  - `currentActiveBacklog` (integer)
  - `totalResolvedCases` (integer)

### 1.3 Update `chartData()`
- For `type === 'resolution'`:
  - Remove percentage-based `avg_rate`.
  - Return:
    - `monthly_active`
    - `monthly_resolved`
    - `yearly_active`
    - `yearly_resolved`
    - `compare_monthly_active`
    - `compare_monthly_resolved`
    - `compare_yearly_active`
    - `compare_yearly_resolved`
    - `current_active_backlog` (integer)
    - `total_resolved_cases` (integer)

---

## 2. Blade Changes (`resources/views/dashboard/city-vet.blade.php`)

### 2.1 Card Header & KPI
- Change card title from **"Resolution Rate Over Time"** to **"Active vs Resolved Confirmed Rabies Cases"**.
- Replace the single percentage big number with one of:
  - **Option A:** Single KPI: `Current Active Backlog` (amber) + subtitle `Open confirmed rabies cases`.
  - **Option B:** Two KPIs: `Active` (amber) and `Resolved` (green).
- Remove the "Avg (Active Months)" label.

### 2.2 Chart Canvas
- Reuse existing `#resolutionRateChart` canvas (no new markup required).

### 2.3 Chart JS Rewrite
- Replace the resolution chart init and dataset builder with a **dual-line chart** modeled on `super-admin.blade.php` `buildSystemActivityChart()`.
- Datasets:
  - **Active Confirmed Cases**
    - `label`: `Active Confirmed Cases`
    - `borderColor`: `#f59e0b` (amber-500) or `#ef4444` (red-500)
    - `backgroundColor`: `rgba(245, 158, 11, 0.1)` or `rgba(239, 68, 68, 0.1)`
    - `fill: true`
    - `tension: 0.3`
    - `pointRadius: 4`
    - `pointHoverRadius: 6`
  - **Resolved Cases**
    - `label`: `Resolved Cases`
    - `borderColor`: `#22c55e` (green-500) or `#3b82f6` (blue-500)
    - `backgroundColor`: `rgba(34, 197, 94, 0.1)` or `rgba(59, 130, 246, 0.1)`
    - `fill: true`
    - `tension: 0.3`
    - `pointRadius: 4`
    - `pointHoverRadius: 6`
- Y-axis:
  - `beginAtZero: true`
  - `ticks: { stepSize: 5 }` (integer counts: 0, 5, 10, 15...)
  - Remove `%` callback.
- X-axis:
  - Keep `grid: { display: false }`.
- Legend:
  - `position: 'top'`
  - `labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { size: 12 }, color: '#374151', useBorderRadius: true, borderRadius: 4 }`
- Tooltip:
  - Standard integer values, no `%` suffix.
- Blank months:
  - Pass `null` for months with zero active AND zero resolved so Chart.js renders gaps rather than zero-height points.

### 2.4 Update Callbacks
- Add `updateResolutionFromAjax(data)` rewrite:
  - Read `data.monthly_active`, `data.monthly_resolved`, `data.compare_monthly_active`, `data.compare_monthly_resolved`.
  - Update `resolutionChart.data.datasets[0].data` and `[1].data`.
  - Call `resolutionChart.update()`.
  - Update KPI text with `data.current_active_backlog` or `data.total_resolved_cases`.

### 2.5 Fetch Function
- Reuse existing `fetchChartData()` pattern, but the controller response keys change for resolution type.

---

## 3. Files To Modify
1. `app/Http/Controllers/CityVetController.php`
2. `resources/views/dashboard/city-vet.blade.php`

---

## 4. Validation
- Load `/city-vet/dashboard` and confirm:
  - Resolution card shows "Active vs Resolved Confirmed Rabies Cases".
  - Dual-line chart renders with amber/green lines and translucent fills.
  - Y-axis shows integer steps (0, 5, 10...).
  - Months with no data show gaps, not zero bars.
  - Filter dropdowns (year, mode, compare year) still refresh the chart correctly.
  - KPI shows an integer count (not a percentage).
