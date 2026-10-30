# Plan: Confirmed Rabies Cases Geomap on /home (View-Only)

**File:** `resources/views/Client/welcome.blade.php` (and `routes/web.php`, `app/Http/Controllers/RabiesCaseController.php`)
**Scope:** Add a view-only Confirmed Rabies Cases geospatial map between the "Missing Pets / Pets for Adoption" section and the "Where to Find Us" section on `/home`. Rename "Missing Pets" to "Lost Pets". No report submission — map is read-only.

## Decisions (resolved)

1. **Map section placement**: Insert a new `<section id="rabies-geomap">` immediately after the Missing Pets section closes (`welcome.blade.php` line 620, `</section>`) and before the "Interactive Map & Location Section" comment (`line 622`). Resulting order: Lost Pets/Pets for Adoption → Rabies Geomap → Where to Find Us.
2. **"Missing Pets" → "Lost Pets"**: Rename in `welcome.blade.php` — section heading, section anchor id (`missing-pets` → `lost-pets`), section description, both filter-tab buttons, both report/adoption CTA buttons, empty-state text, both "View All" links, JS title toggle, quick-services card heading/description/CTA.
3. **Public data source**: `/home` is unauthenticated (route closure at `routes/web.php:146`). Existing rabies heatmap endpoints (`/rabies-geomap/data`, `/rabies/geomap/data`) are behind `auth` + `role:city_vet|assistant_vet`. Add a new **public GET endpoint** `/public/rabies-heatmap-data` returning rabies case counts by barangay (view-only, no write).
4. **Map library**: Leaflet via CDN (`leaflet@1.9.4` CSS + JS), same as `missing-pets-heatmap.blade.php`. No new npm dependency.
5. **GeoJSON**: Consumes existing `/geojson/barangays/dasmarinas-barangays.geojson` (already used by `missing-pets-heatmap.blade.php`). Confirm file exists at `public/geojson/barangays/dasmarinas-barangays.geojson`.
6. **Inline assets only**: `welcome.blade.php` is a standalone view (does NOT `@yield('styles')`/`@yield('scripts')`), so `<style>` and `<script>` blocks must be inline in the inserted section — NOT `@push`/`@endpush` stacks.
7. **View-only behavior**: No "New Report" modal, no filters, no layer switching, no edit/delete. Single rabies layer, color-coded by count (Critical/High/Moderate/Low/None), tooltip on hover, stats pills and legend below the map.
8. **Data model**: Reuse `RabiesCaseController::getRabiesHeatmapData()` logic (cases grouped by `barangay_id`, joined to `Barangay` with `city='dasmarinas'`, lat/lng not null). Return `heatmapData` array with `name`, `latitude`, `longitude`, `count`, `intensity`, plus `totalCases`.

## Data Flow

1. User loads `/home` (public route closure renders `Client.welcome`).
2. Blade inserts new Rabies Geomap section between Lost Pets and Where to Find Us.
3. On `DOMContentLoaded`, JS initializes Leaflet map on `#rabies-heatmap`, fetches `/public/rabies-heatmap-data`.
4. Endpoint queries `RabiesCase` (current year, Dasmariñas barangays with lat/lng) and returns JSON `heatmapData`.
5. JS fetches `/geojson/barangays/dasmarinas-barangays.geojson`, merges case counts into polygon properties, renders colored choropleth map.
6. Stats pills (`Total Cases`, `Affected Barangays`) and severity legend update from data.
7. No user actions available — purely informational/view-only.

## Affected Files

| File | Change |
|------|--------|
| `resources/views/Client/welcome.blade.php` | Rename Missing Pets → Lost Pets; insert Rabies Geomap section (HTML + inline `<style>` + inline `<script>` with Leaflet) |
| `routes/web.php` | Add public route `GET /public/rabies-heatmap-data` → `RabiesCaseController@publicHeatmapData` (outside auth middleware) |
| `app/Http/Controllers/RabiesCaseController.php` | Add `publicHeatmapData(Request $request)` method reusing `getRabiesHeatmapData()` logic |

## Implementation Steps

1. **Rename "Missing Pets" → "Lost Pets"** in `welcome.blade.php`:
   - Line ~336 quick-services card heading `Missing Pets` → `Lost Pets`
   - Line ~338 description "Report a missing pet…" → "Report a lost pet…"
   - Line ~341 CTA `Report Missing Pet` → `Report Lost Pet`
   - Line ~505 section anchor `id="missing-pets"` → `id="lost-pets"`
   - Line ~512 section heading `Missing Pets` → `Lost Pets`
   - Line ~513 missing-tab description → reference "lost pets"
   - Line ~521 filter-tab label `Missing Pets` → `Lost Pets`
   - Line ~526 report CTA `Report Missing Pet` → `Report Lost Pet`
   - Line ~538 comment `<!-- Missing Pets Tab -->` → `<!-- Lost Pets Tab -->`
   - Line ~569 empty state "No missing pets found." → "No lost pets found."
   - Line ~610 "View All Missing Pets" → "View All Lost Pets"
   - Line ~870 JS `titleEl.textContent = filter === 'adoption' ? 'Adoption' : 'Missing Pets'` → `'Lost Pets'`

2. **Add public route** in `routes/web.php` (outside `auth` middleware group, near the `/home` closure):
   ```php
   Route::get('/public/rabies-heatmap-data', [RabiesCaseController::class, 'publicHeatmapData'])->name('public.rabies-heatmap-data');
   ```

3. **Add controller method** `publicHeatmapData(Request $request)` in `RabiesCaseController.php`:
   - `$year = (int) ($request->year ?? date('Y'))`
   - Query `RabiesCase::whereYear('incident_date', $year)->whereNotNull('barangay_id')->whereHas('barangay', fn($q) => $q->where('city','dasmarinas'))->selectRaw('barangay_id, COUNT(*) as count')->groupBy('barangay_id')->get()`
   - Fetch all Dasmariñas barangays with lat/lng
   - Map to `heatmapData` array (`id`, `barangay_id`, `name`, `latitude`, `longitude`, `count`, `intensity`)
   - Return `response()->json(['heatmapData' => ..., 'totalCases' => ..., 'year' => $year])`

4. **Insert Rabies Geomap section** in `welcome.blade.php` after line 620 (`</section>` closing Lost Pets) and before line 622 (`<!-- Interactive Map & Location Section -->`):
   - Section header (title "Confirmed Rabies Cases", subtitle, Public Health Advisory badge)
   - Map container `#rabies-heatmap` with loading spinner + error state
   - Stats pills (`Total Cases`, `Affected Barangays`)
   - Severity legend (Critical/High/Moderate/Low/None)
   - Inline `<style>` for Leaflet container sizing
   - Inline `<script>` loading Leaflet CDN, initializing map, fetching data + GeoJSON, rendering choropleth with tooltips

5. **Verify GeoJSON exists** at `public/geojson/barangays/dasmarinas-barangays.geojson`. If missing, generate from `Barangay` model (city='dasmarinas', lat/lng not null) — same source used by city-vet geomap.

## Validation

- Open `http://127.0.0.1:8000/home` (guest/unauthenticated) → page loads without auth redirect.
- Section order confirmed: Lost Pets/Pets for Adoption → Confirmed Rabies Cases Geomap → Where to Find Us.
- "Lost Pets" text appears everywhere "Missing Pets" previously did; no remaining "Missing Pets" labels in the section.
- Rabies map renders: Leaflet tiles load, colored barangay polygons appear, tooltips show name + count + severity on hover.
- Stats pills show non-zero totals when rabies cases exist in DB; legend shows all 5 severity levels.
- Map error state shows if GeoJSON or data endpoint fails (network/offline simulation).
- Endpoint `GET /public/rabies-heatmap-data` returns 200 JSON with `heatmapData` array and `totalCases` (no auth required).
- Map is view-only: no "New Report" button, no filters, no modal — user cannot submit or edit anything.
- No console JS errors; Leaflet CSS/JS load from CDN.

## Risks & Considerations

- **Unauthenticated access to rabies data**: Endpoint is public read-only (intentional for `/home`). Does not expose case-level PII, only aggregated counts by barangay.
- **GeoJSON missing**: If `dasmarinas-barangays.geojson` doesn't exist, map shows error state. Verify before implementation.
- **Leaflet container height**: `welcome.blade.php` has no `@stack('scripts')`, so inline `<script>` required. Ensure Leaflet CDN loads before map init script (same `<script>` block or ordered).
- **Existing map styles**: The page already loads Leaflet CSS via `missing-pets-heatmap.blade.php` only if that component is included — it is NOT included in `welcome.blade.php`. Include Leaflet CSS + JS in the new section's inline blocks.
- **Color palette**: Reuse city-vet geomap rabies colors (`#dc2626` critical, `#ea580c` high, `#eab308` moderate, `#fde68a` low, `#cbd5e1` none) for visual consistency.

## Out of Scope

- Report submission / "New Report" modal (user confirmed view-only).
- Year/month/severity/date filters.
- Layer switching (rabies vs vaccination).
- Top Barangays modal.
- Mobile-specific map layout beyond existing responsive classes.

## Open Questions

None — all design decisions resolved. Ready for implementation by a file-editing agent.
