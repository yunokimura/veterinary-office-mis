# Plan: Spay/Neuter ( Kapon ) Report Page

## Goal
Create a new standalone Spay/Neuter (Kapon) report view with 4 KPI cards + a table, consistent with the other report pages, served by a new route/controller method (user chose new file + new route over enhancing the existing index).

## Context / findings
- Existing report views live in `resources/views/reports/`: `spay_neuter_index.blade.php` (filters + table, no KPI cards), `animal_bite_index.blade.php` (table + filters), `city-vet.blade.php` (4 KPI cards + charts, no table).
- Existing route group: `Route::prefix('spay-neuter')->name('spay-neuter.')` with middleware `auth, role:city_vet|super_admin|assistant_vet` at `routes/web.php:612`.
- Existing controller: `App\Http\Controllers\SpayNeuterController` already has `index()` (paginated + filters + role scoping) and `dashboard()` (computes totalReports/completed/scheduled).
- Sidebar city_vet "All Reports" dropdown is in `resources/views/layouts/admin.blade.php:270-296`; recently given active-state styling for subitems.

## Decisions
- **View file:** `resources/views/reports/spay_neuter_report.blade.php`, `@extends('layouts.admin')`, display title `Spay/Neuter (<i> Kapon </i>)`.
- **Route:** add `Route::get('/reports/all', [SpayNeuterController::class, 'allReports'])->name('reports.all');` inside the existing `spay-neuter` group → URI `/spay-neuter/reports/all`, name `spay-neuter.reports.all`, same role middleware.
- **Controller:** add `allReports(Request $request)` to `SpayNeuterController` computing 4 KPIs (Total Reports, Completed, Scheduled, Pending) + paginated reports with the same filters as `index()` (status, procedure_type, pet_type, start_date, end_date) + eager load pet/owner/barangay + role-based scoping (non-city_vet/super_admin/assistant_vet see own reports only).
- **Table columns (consistency):** Date | Owner Name | Pet (name + species) | Procedure Type | Status | Actions (View/Edit/Delete) — mirror existing `spay_neuter_index` table markup/styling.
- **4 KPI cards:** Total Reports, Completed Procedures, Scheduled Appointments, Pending Reports. (Adjust metrics by editing the controller query; no schema change needed.)
- **Sidebar:** in `resources/views/layouts/admin.blade.php` city_vet "Reports" dropdown, add a "Spay/Neuter ( Kapon ) Report" subitem underneath the "Anti-Rabies Vaccination" subitem, with `active-nav text-white bg-white/10` styling; add `spay-neuter.reports.all` to the dropdown's open-condition so it expands on this page.
- **Authorization:** reuse existing `authorizeReport`-style scoping logic; controller applies same role-based filtering as `index()`.

## Tasks
1. Register route `spay-neuter.reports.all` in `routes/web.php` inside the existing `spay-neuter` route group.
2. Add `allReports(Request $request)` method to `app/Http/Controllers/SpayNeuterController.php` (4 KPIs + filtered paginated reports + view).
3. Create `resources/views/reports/spay_neuter_report.blade.php` (extends layouts.admin; 4 KPI cards row; filter bar; table; pagination; empty state).
4. Add sidebar subitem underneath "Anti-Rabies Vaccination" (city_vet "Reports" dropdown) + active-state + open-condition for `spay-neuter.reports.all` in `resources/views/layouts/admin.blade.php`.
5. Validate: `php artisan route:list | grep spay-neuter` shows new route; load `/spay-neuter/reports/all` as city_vet, super_admin, assistant_vet (200, no 500); confirm 4 KPI cards + table render and active highlight works.

## Validation / rollback
- If blade fails to compile, check `@extends('layouts.admin')` and section names match `admin.blade.php`.
- Rollback: remove the 4 added lines in routes/web.php, the `allReports` method, the new view file, and sidebar edits; no DB migration involved.

## Open questions
- None. 4 KPI metrics are proposed (Total/Completed/Scheduled/Pending); change in `allReports()` if a different 4th metric is preferred.
