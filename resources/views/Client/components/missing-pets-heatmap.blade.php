<!-- Missing Pets Heatmap Component -->
<div class="relative w-full">
    <div id="missing-pets-heatmap" class="w-full h-[400px] md:h-[500px] rounded-2xl overflow-hidden shadow-lg border border-gray-200" role="application" aria-label="Missing pets heatmap">
        <div class="h-full flex items-center justify-center bg-slate-50">
            <div class="text-center">
                <div class="inline-block animate-pulse w-10 h-10 bg-slate-200 rounded-full mb-3"></div>
                <p class="text-sm text-slate-400">Loading map...</p>
            </div>
        </div>
    </div>
    
    <!-- Stats Pills -->
    <div class="absolute top-4 right-4 z-[1000] flex items-center gap-2">
        <div class="backdrop-blur bg-white/90 rounded-lg px-3 py-2 shadow-sm border border-gray-200/60 flex items-center gap-3">
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-[10px] text-gray-400 font-medium">Total</span>
                <span class="text-sm font-bold text-gray-800" id="mapStatTotal">0</span>
            </div>
            <div class="w-px h-4 bg-gray-200"></div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                <span class="text-[10px] text-gray-400 font-medium">Areas</span>
                <span class="text-sm font-bold text-amber-600" id="mapStatAreas">0</span>
            </div>
        </div>
    </div>

    <!-- Error Display -->
    <div id="map-error" class="hidden absolute top-16 left-1/2 -translate-x-1/2 z-[60]">
        <div class="backdrop-blur bg-red-50/95 border border-red-200 rounded-lg px-4 py-3 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="text-sm font-medium text-red-800" id="error-title">Error loading map</p>
                <p class="text-xs text-red-600" id="error-message">Please refresh the page.</p>
            </div>
            <button onclick="location.reload()" class="px-2.5 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-xs font-medium transition">Retry</button>
        </div>
    </div>
</div>

<!-- Legend -->
<div class="mt-4 flex items-center justify-center gap-6 text-sm">
    <div class="flex items-center gap-2">
        <div class="w-5 h-5 rounded border border-gray-300" style="background: #dc2626;"></div>
        <span class="text-gray-600">High (10+)</span>
    </div>
    <div class="flex items-center gap-2">
        <div class="w-5 h-5 rounded border border-gray-300" style="background: #ea580c;"></div>
        <span class="text-gray-600">Moderate (5-9)</span>
    </div>
    <div class="flex items-center gap-2">
        <div class="w-5 h-5 rounded border border-gray-300" style="background: #eab308;"></div>
        <span class="text-gray-600">Low (1-4)</span>
    </div>
    <div class="flex items-center gap-2">
        <div class="w-5 h-5 rounded border border-gray-300" style="background: #3b82f6;"></div>
        <span class="text-gray-600">Minimal (1)</span>
    </div>
    <div class="flex items-center gap-2">
        <div class="w-5 h-5 rounded border border-gray-300" style="background: #cbd5e1;"></div>
        <span class="text-gray-600">None</span>
    </div>
</div>

<style>
    .leaflet-container {
        height: 100% !important;
        width: 100% !important;
        font-family: 'Inter', system-ui, sans-serif;
        border-radius: 0.75rem;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 0.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        padding: 2px;
    }
    .leaflet-popup-content {
        margin: 10px;
        font-family: 'Inter', system-ui, sans-serif;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 0.8s linear infinite;
    }
    @media (max-width: 640px) {
        #missing-pets-heatmap {
            height: 400px !important;
        }
    }
</style>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Heatmap data passed from PHP
    var heatmapData = @json($missingByBarangayData);
    
    var map = L.map('missing-pets-heatmap', {
        zoomControl: true,
        minZoom: 11,
        maxZoom: 18,
        zoomSnap: 0.5
    }).setView([14.3270, 120.9370], 12);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Hide loading indicator
    var loadingEl = document.querySelector('#missing-pets-heatmap > div');
    if (loadingEl) loadingEl.style.display = 'none';
    
    function getColor(count) {
        return count > 10 ? '#dc2626' :
               count > 5  ? '#ea580c' :
               count > 1  ? '#eab308' :
               count > 0  ? '#3b82f6' :
                            '#cbd5e1';
    }
    
    function getStatus(count) {
        if (count > 10) return 'High';
        if (count > 5) return 'Moderate';
        if (count > 0) return 'Low';
        return 'None';
    }
    
    function style(feature) {
        return {
            fillColor: getColor(feature.properties.count),
            weight: feature.properties.count > 0 ? 2 : 1,
            color: feature.properties.count > 0 ? '#1e293b' : '#94a3b8',
            fillOpacity: feature.properties.count > 0 ? 0.75 : 0.3,
            opacity: 1
        };
    }
    
    function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle({
            weight: 3,
            color: '#4338ca',
            fillOpacity: 0.5
        });
        layer.bringToFront();
    }
    
    function resetHighlight(e) {
        var layer = e.target;
        var count = layer.feature.properties.count || 0;
        geojsonLayer.resetStyle(layer);
    }
    
    function onEachFeature(feature, layer) {
        var name = feature.properties.name || 'Unknown';
        var count = feature.properties.count || 0;
        var status = getStatus(count);
        
        layer.bindTooltip(
            '<div style="font-family: Inter, system-ui; min-width: 130px;">' +
            '<div style="font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 2px;">' +
            name + '</div>' +
            '<div style="font-size: 22px; font-weight: 700; color: ' + getColor(count) + ';">' +
            count + '</div>' +
            '<div style="font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">' +
            status + '</div>' +
            '</div>',
            { direction: 'center', className: '', offset: [0, 0] }
        );
        
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight
        });
    }
    
    // Fetch GeoJSON and create map
    fetch('/geojson/barangays/dasmarinas-barangays.geojson')
        .then(function(response) {
            if (!response.ok) throw new Error('Failed to load GeoJSON: ' + response.status);
            return response.json();
        })
        .then(function(geojson) {
            // Update features with count data
            var countMap = {};
            heatmapData.forEach(function(item) {
                countMap[item.name.toLowerCase().replace(/\s+/g, '')] = item.count;
            });
            
            geojson.features.forEach(function(feature) {
                var name = feature.properties.name || '';
                var key = name.toLowerCase().replace(/\s+/g, '');
                feature.properties.count = countMap[key] || 0;
                feature.properties.name = name;
            });
            
            var geojsonLayer = L.geoJSON(geojson, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(map);
            
            // Fit bounds to city
            var cityBounds = L.geoJSON(geojson).getBounds();
            map.fitBounds(cityBounds, { padding: [40, 40] });
            
            // Update stats
            var total = heatmapData.reduce(function(sum, item) { return sum + item.count; }, 0);
            var areas = heatmapData.filter(function(item) { return item.count > 0; }).length;
            document.getElementById('mapStatTotal').textContent = total;
            document.getElementById('mapStatAreas').textContent = areas;
        })
        .catch(function(err) {
            console.error('Map error:', err);
            var errorDiv = document.getElementById('map-error');
            if (errorDiv) errorDiv.classList.remove('hidden');
            var loadingEl = document.querySelector('#missing-pets-heatmap > div');
            if (loadingEl) loadingEl.style.display = 'none';
        });
});
</script>