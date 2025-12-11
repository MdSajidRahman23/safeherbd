<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Safe Routes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Map Section -->
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div id="map" style="height: 600px;" class="rounded-t-lg"></div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-green-500 rounded"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Safe Route</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Moderate Risk</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-red-500 rounded"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">High Risk</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Routes List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($routes as $route)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden border-l-4 {{ $route->total_score < 5 ? 'border-green-500' : ($route->total_score < 15 ? 'border-yellow-500' : 'border-red-500') }}">
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">{{ $route->route_name }}</h3>
                            
                            <!-- Safety Score -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Safety Score</span>
                                    <span class="text-sm font-bold {{ $route->total_score < 5 ? 'text-green-600' : ($route->total_score < 15 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $route->total_score }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $route->total_score < 5 ? 'bg-green-500' : ($route->total_score < 15 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                         style="width: {{ min(($route->total_score / 30) * 100, 100) }}%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="space-y-2 text-sm mb-4">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Theft Incidents:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $route->theft_count ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Robbery Incidents:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $route->robbery_count ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Kidnapping Incidents:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $route->kidnapping_count ?? 0 }}</span>
                                </div>
                            </div>

                            <!-- Created By & Date -->
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                                Created by {{ $route->creator->name ?? 'Admin' }} • {{ $route->created_at->format('M d, Y') }}
                            </div>

                            <!-- Action -->
                            <button onclick="focusRoute({{ $route->id }})" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition">
                                View on Map
                            </button>

                            <!-- Report Button -->
                            <button onclick="reportUnsafeSpot({{ $route->id }})" class="w-full mt-2 px-4 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-700 dark:text-red-300 rounded-lg text-sm font-semibold transition">
                                Report Unsafe Spot
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-8 text-center">
                        <p class="text-yellow-800 dark:text-yellow-200 font-semibold mb-2">No Safe Routes Available</p>
                        <p class="text-yellow-700 dark:text-yellow-300 text-sm">Safe routes are being created by administrators. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let map;
        let routeLayers = {};

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize map
            map = L.map('map').setView([23.8103, 90.4125], 13); // Dhaka center

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Load routes from server
            const routes = @json($routes);
            routes.forEach(route => {
                if (route.coordinates_json) {
                    const coords = typeof route.coordinates_json === 'string' 
                        ? JSON.parse(route.coordinates_json) 
                        : route.coordinates_json;
                    
                    const color = route.total_score < 5 ? '#22c55e' : (route.total_score < 15 ? '#eab308' : '#ef4444');
                    
                    const polyline = L.polyline(coords, {
                        color: color,
                        weight: 5,
                        opacity: 0.7,
                        smoothFactor: 1.0
                    }).addTo(map).bindPopup(`<strong>${route.route_name}</strong><br/>Score: ${route.total_score}`);
                    
                    routeLayers[route.id] = polyline;
                }
            });
        });

        function focusRoute(routeId) {
            if (routeLayers[routeId]) {
                const bounds = routeLayers[routeId].getBounds();
                map.fitBounds(bounds, { padding: [50, 50] });
                routeLayers[routeId].openPopup();
            }
        }

        function reportUnsafeSpot(routeId) {
            const message = prompt('Describe the unsafe spot or incident you want to report:');
            if (message) {
                fetch('/safe-routes/report', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        route_id: routeId,
                        message: message
                    })
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        alert('Thank you! Your report has been submitted to administrators.');
                    } else {
                        alert('Error submitting report. Please try again.');
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Network error. Please try again.');
                });
            }
        }
    </script>
</x-app-layout>
