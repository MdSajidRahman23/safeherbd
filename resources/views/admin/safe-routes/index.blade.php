@extends('layouts.app')

@section('title', 'Safe Routes Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900">
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-o9N1j7kQY1Qm2w6m0h2qk7mFZ6bN6w5g1p2a9u0wKxQ=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-QV3QG6mQe5m1eYw+6oKfX5s5kXq9m3Yk5+6q0G4Y7vM=" crossorigin=""></script>
    <!-- Safe Route Map JS -->
    <script src="{{ asset('js/safe-route-map.js') }}" defer></script>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl border border-white/20 p-6 shadow-2xl">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">Safe Routes</h1>
                        <p class="text-purple-200">Manage and visualize safe routes with crime point system</p>
                    </div>
                    <a href="{{ route('admin.safe-routes.create') }}" 
                       class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Route
                    </a>
                </div>
            </div>
        </div>

        <!-- Routes List -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Routes Table -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl border border-white/20 p-6 shadow-2xl">
                <h2 class="text-2xl font-bold text-white mb-6">Routes List</h2>
                
                @if($safeRoutes->count() > 0)
                    <div class="space-y-4">
                        @foreach($safeRoutes as $route)
                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-4 border border-white/10 hover:bg-white/10 transition-all duration-300">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-white mb-1">{{ $route->route_name }}</h3>
                                        <div class="flex items-center space-x-4 text-sm">
                                            <span class="text-purple-200">
                                                Created by: {{ $route->creator->name ?? 'Unknown' }}
                                            </span>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                @if($route->total_score < 5) bg-emerald-500/20 text-emerald-300
                                                @elseif($route->total_score <= 10) bg-yellow-500/20 text-yellow-300
                                                @else bg-red-500/20 text-red-300 @endif">
                                                Score: {{ $route->total_score }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.safe-routes.edit', $route->id) }}" 
                                           class="p-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 rounded-xl transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.safe-routes.destroy', $route->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to delete this route?')"
                                                    class="p-2 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-xl transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-purple-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <p class="text-purple-200">No safe routes created yet.</p>
                        <a href="{{ route('admin.safe-routes.create') }}" 
                           class="inline-block mt-4 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl transition-all duration-300">
                            Create your first route
                        </a>
                    </div>
                @endif
            </div>

            <!-- Map Section -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl border border-white/20 p-6 shadow-2xl">
                <h2 class="text-2xl font-bold text-white mb-6">Routes Map</h2>
                <div id="map" class="w-full h-96 rounded-2xl overflow-hidden border border-white/20"></div>
                
                <!-- Legend -->
                <div class="mt-4 bg-white/5 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                    <h3 class="text-lg font-semibold text-white mb-3">Safety Legend</h3>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-emerald-500 rounded-full"></div>
                            <span class="text-emerald-300 text-sm">Safe (< 5)</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                            <span class="text-yellow-300 text-sm">Moderate (5-10)</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                            <span class="text-red-300 text-sm">Dangerous (> 10)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Initialize map
    const map = L.map('map').setView([23.8103, 90.4125], 12);

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Routes data from PHP
    const routes = @json($safeRoutes);

    // Color coding function
    function getRouteColor(score) {
        if (score < 5) return '#10b981'; // emerald
        if (score <= 10) return '#f59e0b'; // yellow
        return '#ef4444'; // red
    }

    // Add routes to map
    routes.forEach(route => {
        try {
            const coordinates = JSON.parse(route.coordinates_json);
            if (Array.isArray(coordinates) && coordinates.length > 0) {
                const color = getRouteColor(route.total_score);
                
                // Create polyline
                const latlngs = coordinates.map(coord => [coord.lat, coord.lng]);
                const polyline = L.polyline(latlngs, {
                    color: color,
                    weight: 4,
                    opacity: 0.8
                }).addTo(map);

                // Add popup
                polyline.bindPopup(`
                    <div class="p-2">
                        <h3 class="font-bold text-gray-800">${route.route_name}</h3>
                        <p class="text-sm text-gray-600">Safety Score: ${route.total_score}</p>
                        <p class="text-xs text-gray-500">Created by: ${route.creator?.name || 'Unknown'}</p>
                    </div>
                `);

                // Add markers for crime points
                coordinates.forEach(coord => {
                    if (coord.crime_type) {
                        const iconColor = coord.score >= 5 ? '#ef4444' : coord.score >= 3 ? '#f59e0b' : '#10b981';
                        const marker = L.circleMarker([coord.lat, coord.lng], {
                            radius: 6,
                            fillColor: iconColor,
                            color: '#fff',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map);

                        marker.bindPopup(`
                            <div class="p-2">
                                <p class="font-semibold text-gray-800">Crime: ${coord.crime_type}</p>
                                <p class="text-sm text-gray-600">Score: ${coord.score}</p>
                                <p class="text-xs text-gray-500">Lat: ${coord.lat}, Lng: ${coord.lng}</p>
                            </div>
                        `);
                    }
                });
            }
        } catch (e) {
            console.error('Error parsing route coordinates:', e);
        }
    });

    // Auto-fit map to show all routes
    if (routes.length > 0) {
        const group = new L.featureGroup(map._layers);
        if (Object.keys(group._layers).length > 0) {
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }
</script>
@endsection
