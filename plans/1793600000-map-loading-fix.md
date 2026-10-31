# Plan: Fix Confirmed Rabies Cases Map Not Loading in welcome.blade.php

**Problem:** The Confirmed Rabies Cases geospatial map section (inserted at `welcome.blade.php:622`) is not loading/rendering properly when accessing `/home` unauthenticated.

**Root Causes Identified:**
1. GeoJSON files fetched from `/geojson/dasmarinas-city-boundary.geojson` and `/geojson/barangays/dasmarinas-barangays.geojson` - files exist in `public/geojson/` but may not be accessible depending on web server config; no explicit routes defined in `routes/web.php` for `/geojson/` endpoints
2. `@json($rabiesHeatmapData)` at line 1032 injects server data; if empty (no rabies cases in DB for current year filtered by city=dasmarinas), may produce null/empty array causing JS errors
3. The `/public/rabies-heatmap-data` API endpoint IS defined (routes/web.php:243) and the controller method EXISTS (RabiesCaseController.php:667), but depends on database records being present
4. Map initialization script at line 908 runs on `DOMContentLoaded`; any JavaScript error prevents map from rendering

**Affected Files (no changes to unrelated code):**
- `resources/views/Client/welcome.blade.php` - map section and inline script/style
- `routes/web.php` - verify public route exists
- `app/Http/Controllers/RabiesCaseController.php` - verify publicHeatmapData method exists

## Implementation Steps

### 1. Add GeoJSON Routes in routes/web.php
Add explicit routes outside the auth middleware group to serve GeoJSON files reliably:

```php
// In routes/web.php, after the /home closure (outside auth group)
Route::get('/geojson/dasmarinas-city-boundary.geojson', function() {
    return response()->file(storage_path('app/public/geojson/dasmarinas-city-boundary.geojson'));
});

Route::get('/geojson/barangays/dasmarinas-barangays.geojson', function() {
    return response()->file(storage_path('app/public/geojson/barangays/dasmarinas-barangays.geojson'));
});
```

### 2. Verify Data Endpoint Returns Data
- Confirm `/public/rabies-heatmap-data` returns valid JSON with `heatmapData` array
- Run: `GET http://127.0.0.1:8000/public/rabies-heatmap-data`
- If empty array, check database: `RabiesCase` table has records with `barangay_id` and `city='dasmarinas'` for current year

### 3. Fix JavaScript Map Initialization (welcome.blade.php inline script)
Add null/empty check after `@json($rabiesHeatmapData)` injection at line 1032:

```javascript
// After line 1032: var heatmapData = @json($rabiesHeatmapData);
if (!heatmapData || heatmapData.length === 0) {
    // Show empty state - keep section visible
    var emptyState = document.getElementById('rabiesHomeEmptyState');
    if (emptyState) emptyState.classList.remove('hidden');
    
    // Hide map container, show message
    var mapContainer = document.getElementById('rabies-home-map');
    if (mapContainer) mapContainer.style.display = 'none';
    
    // Hide error state
    var mapError = document.getElementById('rabiesHomeMapError');
    if (mapError) mapError.classList.add('hidden');
    
    return; // Stop further map initialization
}
```

Also add `.catch()` handlers to all fetch calls with error UI fallback (geojson boundary, geojson barangays, and data endpoint).

### 4. Add Empty State HTML in welcome.blade.php map section
Insert the empty state div after the map container `<div id="rabies-home-map">` and before the inline `<script>` block:

```html
<!-- Right after the map container, before script -->
<div id="rabiesHomeEmptyState" class="rabies-home-empty-state hidden text-center py-20">
    <i class="fa-solid fa-virus-slash w-16 h-16 mx-auto mb-3 text-slate-400"></i>
    <h3 class="text-xl font-bold text-slate-800">No Confirmed Rabies Cases</h3>
    <p class="text-slate-500">No rabies cases reported for <?= date('Y') ?>. Check back later for updates.</p>
</div>
```

### 5. Verify Map Section Integration
- Confirm the Rabies Geomap `<section>` at welcome.blade.php:622 is NOT hidden via CSS
- Verify `#rabies-home-map` element has proper dimensions (the section has `py-20 bg-white border-t border-slate-100`)
- Check that Leaflet CSS/JS CDN links at lines 904-905 load before the map init script

### 6. Add Console Error Logging (view-only, no user impact)
- Wrap map initialization in try/catch
- Log errors to console with descriptive messages
- Show error state UI if map fails to load (already has `#rabiesHomeMapError` at line 774)

## Validation Criteria

- [ ] Open `http://127.0.0.1:8000/home` unauthenticated → page loads without auth redirect
- [ ] Rabies Geomap section renders between Lost Pets and Where to Find Us
- [ ] Leaflet tiles load (no 404 errors for tile layer)
- [ ] Colored barangay polygons appear on map when data exists (choropleth by case count)
- [ ] Tooltips show barangay name + case count + severity on hover when data exists
- [ ] Stats pills show totals when data exists; show 0 when no cases in DB
- [ ] Severity legend shows all 5 levels (Critical/High/Moderate/Low/None) when data exists
- [ ] Map error state visible if GeoJSON or data fetch fails (network offline simulation)
- [ ] Empty state shown when no rabies cases exist in DB for current year (keeps section visible)
- [ ] Endpoint `GET /public/rabies-heatmap-data` returns 200 JSON with `heatmapData` (no auth required)
- [ ] Map is view-only: no "New Report" button, no filters, no layer switching — user cannot submit or edit anything
- [ ] No console JS errors on page load

## Risks & Considerations

- **Unauthenticated data access**: Endpoint is public read-only (intentional for `/home`). Only aggregated counts by barangay, no case-level PII exposed.
- **GeoJSON routes**: Added explicit routes in `routes/web.php` outside auth group to ensure files are always accessible regardless of web server config.
- **Empty state**: When no rabies cases exist, section remains visible with clear message instead of hiding entirely. Map container hidden, empty state shown.
- **Leaflet container height**: `welcome.blade.php` has no `@stack('scripts')`, so inline `<script>` block required. Ensure Leaflet CDN loads before map init script within same `<script>` block.
- **Existing map styles**: The page already loads Tailwind CSS and FontAwesome. Leaflet CSS/JS must be included via CDN in the inline script block or as separate `<link>`/`<script>` tags before the map init script.
- **Color palette**: Reuse city-vet geomap rabies colors (`#dc2626` critical, `#ea580c` high, `#eab308` moderate, `#fde68a` low, `#cbd5e1` none) for visual consistency.

## Out of Scope

- Report submission / "New Report" modal (confirmed view-only in original plan)
- Year/month/severity/date filters
- Layer switching (rabies vs vaccination)
- Top Barangays modal
- Mobile-specific map layout beyond existing responsive classes
- Any changes to authentication or authorization middleware

## Open Questions (Resolved)

### 1. GeoJSON Routes
**Recommendation:** Add explicit routes in `routes/web.php` outside the auth middleware group to serve the GeoJSON files.

**Rationale:** While files exist in `public/geojson/`, some web servers (nginx) may not serve them directly, causing 404 errors and map failure. Explicit routes ensure the map works reliably regardless of server config. This is a minimal one-line addition per GeoJSON file.

**Implementation:** Add to `routes/web.php` after the `/home` closure (outside the `Auth::check()` middleware group):
```php
Route::get('/geojson/dasmarinas-city-boundary.geojson', function() {
    return response()->file(storage_path('app/public/geojson/dasmarinas-city-boundary.geojson'));
});

Route::get('/geojson/barangays/dasmarinas-barangays.geojson', function() {
    return response()->file(storage_path('app/public/geojson/barangays/dasmarinas-barangays.geojson'));
});
```

### 2. Map Empty State Handling
**Recommendation:** Show an empty state when no rabies cases exist, but keep the section visible (not hidden). Include a message and minimal map initialization.

**Implementation:** In the inline script, after `@json($rabiesHeatmapData)` injection at line 1032, add a null/empty check:

```javascript
// After line 1032: var heatmapData = @json($rabiesHeatmapData);
if (!heatmapData || heatmapData.length === 0) {
    // Show empty state UI - keep section visible
    var emptyState = document.getElementById('rabiesHomeEmptyState');
    if (emptyState) emptyState.classList.remove('hidden');
    
    // Hide the map container, show empty state message
    var mapContainer = document.getElementById('rabies-home-map');
    if (mapContainer) mapContainer.style.display = 'none';
    
    // Optionally show error state
    var mapError = document.getElementById('rabiesHomeMapError');
    if (mapError) mapError.classList.add('hidden');
    
    return; // Stop further map initialization
}
```

**Empty state HTML** (add to the map section, after the map container `<div>` but before the `<script>` block):
```html
<!-- Add this right after the map container div, before the script -->
<div id="rabiesHomeEmptyState" class="rabies-home-empty-state hidden text-center py-20">
    <i class="fa-solid fa-virus-slash w-16 h-16 mx-auto mb-3 text-slate-400"></i>
    <h3 class="text-xl font-bold text-slate-800">No Confirmed Rabies Cases</h3>
    <p class="text-slate-500">No rabies cases reported for <?= date('Y') ?>. Check back later for updates.</p>
</div>
```

This approach:
- Keeps the section visible even with no data (doesn't hide the entire Rabies Geomap section)
- Shows clear visual feedback (icon + message) that cases simply haven't been reported yet
- Gracefully handles the empty data case without JavaScript errors
- Maintains view-only behavior (no user actions possible)
- Allows the map to potentially load data later if cases are added to the database