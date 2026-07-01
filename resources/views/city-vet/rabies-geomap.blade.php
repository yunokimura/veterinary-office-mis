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

    .geomap-wrapper {
        position: relative;
        width: auto;
        flex: 1;
        margin: -1.5rem;
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
            loadCaseData();
        })
        .catch(function(err) {
            console.error('GeoJSON Error:', err);
            document.getElementById('mapError').classList.remove('hidden');
        });

    function loadCaseData() {
        var params = new URLSearchParams();
        params.append('year', filters.year);

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