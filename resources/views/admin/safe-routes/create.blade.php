@extends('layouts.app')

@section('title', 'Create Safe Route')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl border border-white/20 p-6 shadow-2xl">
                <div class="flex items-center">
                    <a href="{{ route('admin.safe-routes.index') }}" 
                       class="mr-4 p-2 bg-white/10 hover:bg-white/20 rounded-xl transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">Create Safe Route</h1>
                        <p class="text-purple-200">Draw your route and mark crime points on the map</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.safe-routes.store') }}" method="POST" id="routeForm">
            @csrf
            
            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl border border-white/20 p-6 shadow-2xl">
                        <h2 class="text-2xl font-bold text-white mb-6">Route Details</h2>
                        
                        <div class="space-y-6">
                            <!-- Route Name -->
                            <div>
                                <label for="route_name" class="block text-sm font-medium text-purple-200 mb-2">
                                    Route Name
                                </label>
                                <input type="text" 
                                       id="route_name" 
                                       name="route_name" 
                                       required
                                       class="w-full px-4 py-3 bg-white/5 border border-white/20 rounded-2xl text-white placeholder-purple-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                       placeholder="Enter route name (e.g., Dhaka University to Gulshan)">
                                @error('route_name')
                                    <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Crime Points Summary -->
                            <div>
                                <label class="block text-sm font-medium text-purple-200 mb-2">
                                    Crime Points Summary
                                </label>
                                <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                                    <div class="text-center">
                                        <div id="totalScore" class="text-3xl font-bold text-emerald-400 mb-1">0</div>
                                        <div class="text-purple-200 text-sm">Total Crime Score</div>
                                    </div>
                                    <div class="mt-3 space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-purple-200">Theft points:</span>
                                            <span id="theftCount" class="text-white">0</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-purple-200">Robbery points:</span>
                                            <span id="robberyCount" class="text-white">0</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-purple-200">Kidnapping points:</span>
                                            <span id="kidnappingCount" class="text-white">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Coordinates JSON (Hidden) -->
                            <input type="hidden" id="coordinates_json" name="coordinates" value="">
                            
                            <!-- Crime Type Selector -->
                            <div>
                                <label class="block text-sm font-medium text-purple-200 mb-2">
                                    Current Crime Type for New Points
                                </label>
                                <select id="crimeType" 
                                        class="w-full px-4 py-3 bg-white/5 border border-white/20 rounded-2xl text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <option value="">Select crime type...</option>
                                    <option value="theft" data-score="1">Theft (Score: 1)</option>
                                    <option value="robbery" data-score="3">Robbery (Score: 3)</option>
                                    <option value="kidnapping" data-score="5">Kidnapping (Score: 5)</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-4">
                                <button type="button" 
                                        id="clearRoute"
                                        class="flex-1 px-4 py-3 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-2xl transition-all duration-300">
                                    Clear Route
                                </button>
                                <button type="submit" 
                                        id="saveRoute"
                                        class="flex-1 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled>
                                    Save Route
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl border border-white/20 p-6 shadow-2xl">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-white">Interactive Route Map</h2>
                            <div class="flex space-x-2">
                                <button type="button" 
                                        id="toggleRouteMode"
                                        class="px-4 py-2 bg-blue-500/30 text-blue-300 rounded-xl transition-all duration-300">
                                    Route Mode
                                </button>
                                <button type="button" 
                                        id="toggleCrimeMode"
                                        class="px-4 py-2 bg-orange-500/20 hover:bg-orange-500/30 text-orange-300 rounded-xl transition-all duration-300">
                                    Crime Mode
                                </button>
                            </div>
                        </div>
                        
                        <!-- Map Container -->
                        <div class="relative">
                            <div id="map" class="w-full h-96 lg:h-[500px] rounded-2xl overflow-hidden border border-white/20"></div>
                            
                            <!-- Legend -->
                            <div class="absolute bottom-4 left-4 bg-white/10 backdrop-blur-md rounded-lg p-3 text-sm text-white border border-white/20 shadow-lg">
                                <div class="flex items-center space-x-3">
                                    <span class="w-3 h-3 rounded-full" style="background:#3B82F6"></span>
                                    <span>Route Path</span>
                                </div>
                                <div class="flex items-center space-x-3 mt-2">
                                    <span class="w-3 h-3 rounded-full" style="background:#10B981"></span>
                                    <span>Theft (Score: 1)</span>
                                </div>
                                <div class="flex items-center space-x-3 mt-2">
                                    <span class="w-3 h-3 rounded-full" style="background:#F59E0B"></span>
                                    <span>Robbery (Score: 3)</span>
                                </div>
                                <div class="flex items-center space-x-3 mt-2">
                                    <span class="w-3 h-3 rounded-full" style="background:#EF4444"></span>
                                    <span>Kidnapping (Score: 5)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="mt-4 bg-white/5 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                            <h3 class="text-lg font-semibold text-white mb-2">Instructions</h3>
                            <div class="text-sm text-purple-200 space-y-1">
                                <p>• <strong>Route Mode:</strong> Click on the map to add route points</p>
                                <p>• <strong>Crime Mode:</strong> Click on the map to mark crime points (select crime type first)</p>
                                <p>• <strong>Colors:</strong> Blue = Route, Green = Theft, Orange = Robbery, Red = Kidnapping</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    const map = L.map('map').setView([23.8103, 90.4125], 12);

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Route data
    let routePoints = [];
    let crimePoints = [];
    let currentMode = 'route'; // 'route' or 'crime'
    
    // Current polyline and markers
    let routePolyline = null;
    let crimeMarkers = [];

    // UI Elements
    const routeModeBtn = document.getElementById('toggleRouteMode');
    const crimeModeBtn = document.getElementById('toggleCrimeMode');
    const crimeTypeSelect = document.getElementById('crimeType');
    const coordinatesInput = document.getElementById('coordinates_json');
    const totalScoreElement = document.getElementById('totalScore');
    const theftCountElement = document.getElementById('theftCount');
    const robberyCountElement = document.getElementById('robberyCount');
    const kidnappingCountElement = document.getElementById('kidnappingCount');
    const saveButton = document.getElementById('saveRoute');
    const clearButton = document.getElementById('clearRoute');

    // Update UI
    function updateUI() {
        // Calculate total score
        const totalScore = crimePoints.reduce((sum, point) => sum + point.score, 0);
        totalScoreElement.textContent = totalScore;
        
        // Update crime counts
        const theftCount = crimePoints.filter(p => p.crime_type === 'theft').length;
        const robberyCount = crimePoints.filter(p => p.crime_type === 'robbery').length;
        const kidnappingCount = crimePoints.filter(p => p.crime_type === 'kidnapping').length;
        
        theftCountElement.textContent = theftCount;
        robberyCountElement.textContent = robberyCount;
        kidnappingCountElement.textContent = kidnappingCount;
        
        // Update color based on score
        if (totalScore < 5) {
            totalScoreElement.className = 'text-3xl font-bold text-emerald-400 mb-1';
        } else if (totalScore <= 10) {
            totalScoreElement.className = 'text-3xl font-bold text-yellow-400 mb-1';
        } else {
            totalScoreElement.className = 'text-3xl font-bold text-red-400 mb-1';
        }
        
        // Enable save button if route has points
        saveButton.disabled = routePoints.length === 0;
        
        // Update coordinates input
        const allPoints = [...routePoints, ...crimePoints];
        coordinatesInput.value = JSON.stringify(allPoints);
    }

    // Mode switching
    function setMode(mode) {
        currentMode = mode;
        
        if (mode === 'route') {
            routeModeBtn.className = 'px-4 py-2 bg-blue-500/30 text-blue-300 rounded-xl transition-all duration-300';
            crimeModeBtn.className = 'px-4 py-2 bg-orange-500/20 hover:bg-orange-500/30 text-orange-300 rounded-xl transition-all duration-300';
        } else {
            routeModeBtn.className = 'px-4 py-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 rounded-xl transition-all duration-300';
            crimeModeBtn.className = 'px-4 py-2 bg-orange-500/30 text-orange-300 rounded-xl transition-all duration-300';
        }
    }

    // Add route point
    function addRoutePoint(lat, lng) {
        routePoints.push({ lat, lng });
        
        // Update polyline
        if (routePolyline) {
            map.removeLayer(routePolyline);
        }
        
        const latlngs = routePoints.map(point => [point.lat, point.lng]);
        routePolyline = L.polyline(latlngs, {
            color: '#3b82f6',
            weight: 4,
            opacity: 0.8
        }).addTo(map);
        
        updateUI();
    }

    // Add crime point
    function addCrimePoint(lat, lng) {
        const crimeType = crimeTypeSelect.value;
        if (!crimeType) {
            alert('Please select a crime type first!');
            return;
        }
        
        const selectedOption = crimeTypeSelect.options[crimeTypeSelect.selectedIndex];
        const score = parseInt(selectedOption.dataset.score);
        
        const crimePoint = {
            lat,
            lng,
            crime_type: crimeType,
            score: score
        };
        
        crimePoints.push(crimePoint);
        
        // Add marker with color based on crime type
        let color;
        switch(crimeType) {
            case 'theft': color = '#10b981'; break;
            case 'robbery': color = '#f59e0b'; break;
            case 'kidnapping': color = '#ef4444'; break;
            default: color = '#6b7280';
        }
        
        const marker = L.circleMarker([lat, lng], {
            radius: 8,
            fillColor: color,
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map);
        
        marker.bindPopup(`
            <div class="p-2">
                <p class="font-semibold text-gray-800">Crime: ${crimeType}</p>
                <p class="text-sm text-gray-600">Score: ${score}</p>
            </div>
        `);
        
        crimeMarkers.push(marker);
        updateUI();
    }

    // Clear route
    function clearRoute() {
        routePoints = [];
        crimePoints = [];
        
        if (routePolyline) {
            map.removeLayer(routePolyline);
            routePolyline = null;
        }
        
        crimeMarkers.forEach(marker => map.removeLayer(marker));
        crimeMarkers = [];
        
        updateUI();
    }

    // Event listeners
    routeModeBtn.addEventListener('click', () => setMode('route'));
    crimeModeBtn.addEventListener('click', () => setMode('crime'));
    clearButton.addEventListener('click', clearRoute);

    // Map click event
    map.on('click', function(e) {
        const { lat, lng } = e.latlng;
        
        if (currentMode === 'route') {
            addRoutePoint(lat, lng);
        } else {
            addCrimePoint(lat, lng);
        }
    });

    // Form submission
    document.getElementById('routeForm').addEventListener('submit', function(e) {
        if (routePoints.length === 0) {
            e.preventDefault();
            alert('Please add at least one route point!');
            return false;
        }
        
        // Ensure coordinates are set
        const allPoints = [...routePoints, ...crimePoints];
        document.getElementById('coordinates_json').value = JSON.stringify(allPoints);
    });

    // Initialize
    setMode('route');
    updateUI();
});
</script>
@endpush
