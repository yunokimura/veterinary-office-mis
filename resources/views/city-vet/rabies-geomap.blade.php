@extends('layouts.admin')

@section('title', 'Rabies Geomap')
@section('header', 'Rabies Case Distribution')
@section('subheader', 'Dasmariñas City Disease Surveillance')

@php
    $currentYear = date('Y');
    $selectedYear = (int) ($year ?? $currentYear);
    $years = range($currentYear, $currentYear - 5);
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    $totalCases = collect($heatmapData)->sum('count');
    $activeBarangays = collect($heatmapData)->where('count', '>', 0)->count();
    $criticalCount = collect($heatmapData)->where('count', '>', 20)->count();
@endphp

@section('content')
    <div class="geomap-wrapper">

        {{-- Map Container --}}
        <div id="geomap" class="geomap-leaflet" role="application" aria-label="Rabies cases geomap">
            <div class="geomap-loading">
                <div class="text-center">
                    <div class="inline-block animate-pulse w-10 h-10 bg-slate-200 rounded-full mb-3"></div>
                    <p class="text-sm text-slate-400">Initializing map...</p>
                </div>
            </div>
        </div>

        {{-- Floating: Stats Pills (top-right) --}}
        <div class="geomap-stats">
            <div class="geomap-stats-inner">
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                    <span class="text-[10px] text-slate-400 font-medium">Total</span>
                    <span class="text-sm font-bold text-slate-800" id="statTotalCases">{{ $totalCases }}</span>
                </div>
                <div class="w-px h-4 bg-slate-200"></div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                    <span class="text-[10px] text-slate-400 font-medium">Affected</span>
                    <span class="text-sm font-bold text-amber-600" id="statAffected">{{ $activeBarangays }}</span>
                </div>
                <div class="w-px h-4 bg-slate-200"></div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                    <span class="text-[10px] text-slate-400 font-medium">Critical</span>
                    <span class="text-sm font-bold text-rose-600" id="statCritical">{{ $criticalCount }}</span>
                </div>
            </div>
        </div>

        {{-- Floating: Filter Button (top-right, below stats) --}}
        <div class="geomap-filter-controls" x-data="{ filterOpen: false }">
            <button @click="filterOpen = !filterOpen" @click.away="filterOpen = false" class="filter-toggle-btn">
                <i class="bi bi-funnel text-[10px]"></i>
                <span>Filters</span>
                <i class="bi bi-chevron-down text-[8px] opacity-40"></i>
            </button>

            {{-- Filter Panel --}}
            <div x-show="filterOpen" x-transition class="filter-panel">
                {{-- Year Filter --}}
                <div class="filter-section">
                    <label class="filter-label">Year</label>
                    <select id="filterYear" onchange="setFilter('year', parseInt(this.value))" class="filter-select">
                        @foreach($years as $y)
                        <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Month Filter --}}
                <div class="filter-section">
                    <label class="filter-label">Month</label>
                    <select id="filterMonth" onchange="setFilter('month', this.value ? parseInt(this.value) : null)" class="filter-select">
                        <option value="">All Months</option>
                        @foreach($months as $num => $name)
                        <option value="{{ $num }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Week Filter --}}
                <div class="filter-section">
                    <label class="filter-label">Week</label>
                    <select id="filterWeek" onchange="setFilter('week', this.value ? parseInt(this.value) : null)" class="filter-select">
                        <option value="">All Weeks</option>
                        @for($w = 1; $w <= 53; $w++)
                        <option value="{{ $w }}">Week {{ $w }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Date Range Filter --}}
                <div class="filter-section">
                    <label class="filter-label">Date Range</label>
                    <div class="filter-date-range">
                        <input type="date" id="filterDateFrom" class="filter-date-input" placeholder="From">
                        <span class="filter-date-separator">to</span>
                        <input type="date" id="filterDateTo" class="filter-date-input" placeholder="To">
                    </div>
                </div>

                <div class="filter-actions">
                    <button id="resetViewBtn" class="filter-reset-btn">
                        <i class="bi bi-arrows-fullscreen text-[10px]"></i> Reset View
                    </button>
                </div>
            </div>
        </div>

        {{-- Floating: Legend (bottom-right) --}}
        <x-map-legend :time-filter="'Yearly'" />

        {{-- Loading Overlay --}}
        <div id="mapLoading" class="geomap-loading-overlay" style="display: none;">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-10 w-10 border-[3px] border-indigo-500 border-t-transparent"></div>
                <p class="mt-3 text-sm text-slate-500 font-medium">Loading map data...</p>
            </div>
        </div>

        {{-- Error --}}
        <div id="mapError" class="geomap-error hidden">
            <div class="geomap-error-inner">
                <i class="bi bi-exclamation-triangle text-red-500"></i>
                <div>
                    <p class="text-sm font-medium text-red-800" id="errorTitle">Error loading map</p>
                    <p class="text-xs text-red-600" id="errorMessage">Please refresh the page.</p>
                </div>
                <button onclick="location.reload()" class="px-2.5 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-xs font-medium transition">Retry</button>
            </div>
        </div>
    </div>
@endsection

{{-- Styles --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* ========================================
       Geomap Layout — uses viewport height
       instead of flex-1/min-h-0 to ensure
       Leaflet always has a definite container
       ======================================== */

    /* Scoped override: only when .geomap-wrapper exists inside .content-wrapper */
    .content-wrapper:has(.geomap-wrapper) {
        height: calc(100vh - 64px) !important;
        min-height: 0 !important;
        overflow: hidden !important;
        padding: 0.5rem !important;
    }

    .geomap-wrapper {
        position: relative;
        width: auto;
        flex: 1;
        margin: -0.5rem;
        height: calc(100vh - 4rem);
        min-height: 400px;
        overflow: hidden;
    }

    .geomap-leaflet {
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    .leaflet-container {
        height: 100% !important;
        width: 100% !important;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .leaflet-control {
        z-index: 1001 !important;
    }
    .leaflet-popup {
        z-index: 1003 !important;
    }
    .leaflet-tooltip {
        z-index: 1003 !important;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    .leaflet-popup-content {
        margin: 14px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    /* Loading placeholder */
    .geomap-loading {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        z-index: 0;
    }

    .geomap-loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1004;
    }

    /* Floating stats pills */
    .geomap-stats {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 1000;
        pointer-events: none;
    }
    .geomap-stats-inner {
        backdrop-filter: blur(12px);
        background: rgba(255,255,255,0.9);
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        pointer-events: auto;
    }

    /* Error */
    .geomap-error {
        position: absolute;
        top: 4rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 60;
    }
    .geomap-error-inner {
        backdrop-filter: blur(12px);
        background: rgba(254,242,242,0.95);
        border: 1px solid #fecaca;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }


    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 0.8s linear infinite;
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Filter Controls */
    .geomap-filter-controls {
        position: absolute;
        top: 4.5rem;
        right: 1rem;
        z-index: 1000;
    }

    .filter-toggle-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer;
        color: #475569;
        font-size: 11px;
        font-weight: 500;
        transition: all 0.15s;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .filter-toggle-btn:hover {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .filter-panel {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(12px);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 12px;
        width: 220px;
        z-index: 1005;
    }

    .filter-section {
        margin-bottom: 12px;
    }
    .filter-section:last-of-type {
        margin-bottom: 0;
    }

    .filter-label {
        display: block;
        font-size: 10px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .filter-select {
        width: 100%;
        padding: 5px 8px;
        font-size: 11px;
        font-weight: 500;
        color: #334155;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .filter-select:hover {
        border-color: #cbd5e1;
    }
    .filter-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.15);
    }

    .filter-date-range {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-date-input {
        flex: 1;
        padding: 4px 6px;
        font-size: 10px;
        font-weight: 500;
        color: #334155;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .filter-date-input:hover {
        border-color: #cbd5e1;
    }
    .filter-date-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.15);
    }

    .filter-date-separator {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
    }

    .filter-actions {
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
    }

    .filter-reset-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 500;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .filter-reset-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .leaflet-control-zoom {
            display: none;
        }
        .geomap-wrapper {
            height: calc(100vh - 9rem);
            margin: -1.5rem;
        }
        .geomap-stats {
            top: 0.5rem;
            right: 0.5rem;
        }
        .geomap-filter-controls {
            top: 3.75rem;
            right: 0.5rem;
        }
        .filter-panel {
            width: 180px;
            padding: 10px;
        }
        .filter-toggle-btn {
            padding: 5px 10px;
            font-size: 10px;
        }
        .filter-toggle-btn span {
            display: none;
        }
    }
</style>
@endpush

{{-- Scripts --}}
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var filters = { year: {{ $selectedYear }}, month: null, week: null };
    var map, barangayLayer, outsideMaskLayer, cityBounds, geojsonData;

    // --- Initialize Map ---
    map = L.map('geomap', {
        zoomControl: true,
        minZoom: 12,
        maxZoom: 18,
        zoomSnap: 0.5,
        worldCopyJump: false
    }).setView([14.3270, 120.9370], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19
    }).addTo(map);

    // Hide the loading placeholder
    var loadingEl = document.querySelector('.geomap-loading');
    if (loadingEl) loadingEl.style.display = 'none';

    // Ensure map fills its container after init
    setTimeout(function() {
        map.invalidateSize();
    }, 150);

    // --- Color helpers ---
    function getColor(cases) {
        return cases > 20 ? '#dc2626'
             : cases > 10 ? '#ea580c'
             : cases > 5  ? '#eab308'
             : cases > 0  ? '#fde68a'
                          : '#cbd5e1';
    }
    function getBorderColor(cases) {
        return cases > 0 ? '#1e293b' : '#94a3b8';
    }

    function style(feature) {
        var c = feature.properties.cases || 0;
        return {
            fillColor: getColor(c),
            weight: c > 0 ? 2.5 : 1.5,
            color: getBorderColor(c),
            fillOpacity: c > 0 ? 0.8 : 0.45,
            opacity: 1
        };
    }

    function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle({ weight: 4, color: '#4338ca', fillOpacity: 0.55 });
        layer.bringToFront();
    }

    function resetHighlight(e) {
        var c = e.target.feature.properties.cases || 0;
        e.target.setStyle({
            weight: c > 0 ? 2.5 : 1.5,
            color: getBorderColor(c),
            fillOpacity: c > 0 ? 0.8 : 0.45
        });
    }

    function onEachFeature(feature, layer) {
        var name = feature.properties.name || 'Unknown';
        var cases = feature.properties.cases || 0;
        var status = cases > 20 ? 'Critical'
                   : cases > 10 ? 'High'
                   : cases > 5  ? 'Moderate'
                   : cases > 0  ? 'Low'
                                : 'No Cases';

        layer.bindTooltip(
            '<div style="font-family:Inter,system-ui;min-width:110px;">' +
            '<div style="font-size:13px;font-weight:600;color:#1e293b;margin-bottom:2px;">' + name + '</div>' +
            '<div style="font-size:20px;font-weight:700;color:' + getColor(cases) + ';">' + cases + '</div>' +
            '<div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-top:1px;">' + status + '</div>' +
            '</div>',
            { direction: 'center', className: '', offset: [0, 0], pane: 'popupPane' }
        );
        layer.on({ mouseover: highlightFeature, mouseout: resetHighlight });
    }

    // --- Outside city mask ---
    function createOutsideMask(bounds) {
        var s = bounds.getSouth(), n = bounds.getNorth(),
            e = bounds.getEast(), w = bounds.getWest();
        return L.polygon([
            [[s-10, w-10], [s-10, e+10], [n+10, e+10], [n+10, w-10], [s-10, w-10]],
            [[s, e], [n, e], [n, w], [s, w], [s, e]]
        ], {
            fillColor: '#f1f5f9',
            fillOpacity: 0.7,
            color: 'transparent',
            weight: 0
        });
    }

    // --- Boundary ---
    fetch('/geojson/dasmarinas-city-boundary.geojson')
        .then(function(r) { return r.json(); })
        .then(function(boundary) {
            var polys = {
                type: 'FeatureCollection',
                features: boundary.features.filter(function(f) {
                    return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon';
                })
            };
            L.geoJSON(polys, {
                fillColor: 'transparent', color: '#334155', weight: 2.5, opacity: 1
            }).addTo(map);

            cityBounds = L.geoJSON(polys).getBounds();
            outsideMaskLayer = createOutsideMask(cityBounds).addTo(map);
            map.setMaxBounds(cityBounds);
            map.fitBounds(cityBounds);
            map.on('drag', function() {
                map.panInsideBounds(cityBounds, { animate: false });
            });
        });

    // --- Barangay GeoJSON + Case Data ---
    function normalizeBarangayName(name) {
        var n = name.toLowerCase()
            .replace(/\s+/g, '')
            .replace(/\(.*\)/, '');
        n = n.replace(/iii$/, '3');
        n = n.replace(/ii$/, '2');
        n = n.replace(/iv$/, '4');
        n = n.replace(/v$/, '5');
        n = n.replace(/i$/, '1');
        return n;
    }

    fetch('/geojson/barangays/dasmarinas-barangays.geojson')
        .then(function(r) { return r.json(); })
        .then(function(geojson) {
            geojsonData = geojson;
            fetchFilteredData();
        })
        .catch(function(err) {
            console.error('GeoJSON Error:', err);
            document.getElementById('mapError').classList.remove('hidden');
        });

    // Filter functionality
    window.setFilter = function(type, value) {
        filters[type] = value;
        fetchFilteredData();
    };

    // Date picker handlers
    document.getElementById('filterDateFrom')?.addEventListener('change', function() {
        filters.date_from = this.value || null;
        fetchFilteredData();
    });

    document.getElementById('filterDateTo')?.addEventListener('change', function() {
        filters.date_to = this.value || null;
        fetchFilteredData();
    });

    function fetchFilteredData() {
        var params = new URLSearchParams();
        params.append('year', filters.year);
        if (filters.month) params.append('month', filters.month);
        if (filters.week) params.append('week', filters.week);
        if (filters.date_from) params.append('date_from', filters.date_from);
        if (filters.date_to) params.append('date_to', filters.date_to);

        var baseUrl = window.location.pathname.replace(/\/$/, '');
        fetch(baseUrl + '/data?' + params.toString())
            .then(function(r) { return r.json(); })
            .then(function(data) {
                updateMap(data.heatmapData);
                updateStats(data);
            })
            .catch(function(err) {
                console.error('Data Error:', err);
                document.getElementById('mapError').classList.remove('hidden');
            });
    }

    function updateMap(heatmapData) {
        var caseData = {};
        heatmapData.forEach(function(item) {
            caseData[normalizeBarangayName(item.name)] = item.count;
        });

        if (!geojsonData || !geojsonData.features) return;

        var copy = JSON.parse(JSON.stringify(geojsonData));
        copy.features.forEach(function(f) {
            var name = normalizeBarangayName(f.properties.name || '');
            f.properties.cases = caseData[name] || 0;
        });

        var polygons = {
            type: 'FeatureCollection',
            features: copy.features.filter(function(f) {
                return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon';
            })
        };

        if (barangayLayer) map.removeLayer(barangayLayer);
        barangayLayer = L.geoJSON(polygons, {
            style: style,
            onEachFeature: onEachFeature,
            pointToLayer: function() { return null; }
        }).addTo(map);
        barangayLayer.bringToFront();

        map.eachLayer(function(l) {
            if (l instanceof L.TileLayer) l.bringToBack();
        });
    }

    function updateStats(data) {
        var total = 0, affected = 0, critical = 0;
        data.heatmapData.forEach(function(item) {
            total += item.count;
            if (item.count > 0) affected++;
            if (item.count > 20) critical++;
        });
        document.getElementById('statTotalCases').textContent = total;
        document.getElementById('statAffected').textContent = affected;
        document.getElementById('statCritical').textContent = critical;
    }

    // --- Reset view button (in map zoom controls area) ---
    // We'll add it to the map's zoom control position
    var resetControl = L.control({ position: 'topleft' });
    resetControl.onAdd = function() {
        var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
        div.innerHTML = '<a href="#" title="Reset view" style="display:flex;align-items:center;justify-content:center;width:30px;height:30px;font-size:16px;cursor:pointer;">⟲</a>';
        div.onclick = function(e) {
            e.preventDefault();
            if (cityBounds) map.fitBounds(cityBounds);
            else map.setView([14.3270, 120.9370], 12);
        };
        return div;
    };
    resetControl.addTo(map);
});
</script>
@endpush