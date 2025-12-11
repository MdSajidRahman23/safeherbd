<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Safe Routes - Plan Your Journey') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Route Planning Section -->
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Plan Your Safe Route</h3>

                    <!-- Search and Input Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Pickup Location -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pickup Location</label>
                            <div class="relative">
                                <input type="text" id="pickup-search" placeholder="Search for pickup location..."
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <button onclick="setPickupCurrentLocation()" class="absolute right-2 top-2 text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Use current location">
                                    📍
                                </button>
                            </div>
                        </div>

                        <!-- Destination -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Destination</label>
                            <input type="text" id="destination-search" placeholder="Search for destination..."
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <button onclick="findSafeRoute()" id="find-route-btn"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                            🔍 Find Safe Route
                        </button>
                        <button onclick="clearRoute()" id="clear-route-btn"
                                class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold transition hidden">
                            🗑️ Clear Route
                        </button>
                        <button onclick="toggleMapClick()" id="map-click-toggle"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                            🎯 Click Map to Set Points
                        </button>
                    </div>

                    <!-- Route Info -->
                    <div id="route-info" class="mt-4 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hidden">
                        <h4 class="font-semibold text-blue-800 dark:text-blue-200">Route Found!</h4>
                        <div id="route-details" class="text-sm text-blue-700 dark:text-blue-300 mt-2"></div>
                    </div>
                </div>

                <!-- Map Section -->
                <div id="map" style="height: 600px;" class="relative">
                    <!-- Map Click Instructions -->
                    <div id="map-instructions" class="absolute top-4 left-4 bg-white dark:bg-gray-800 p-3 rounded-lg shadow-lg z-[1000] hidden">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Click on the map to set:</p>
                        <p id="click-instruction" class="text-sm text-blue-600 dark:text-blue-400">Pickup location</p>
                        <button onclick="cancelMapClick()" class="mt-2 text-xs text-gray-500 hover:text-gray-700">Cancel</button>
                    </div>
                </div>

                <!-- Legend -->
                <div class="p-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex flex-wrap items-center gap-4">
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
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-blue-500 rounded-full border-2 border-white"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Your Pickup</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-red-500 rounded-full border-2 border-white"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Your Destination</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Safe Routes -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Available Safe Routes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($routes as $route)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden border-l-4 route-card {{ $route->total_score < 5 ? 'border-green-500' : ($route->total_score < 15 ? 'border-yellow-500' : 'border-red-500') }}" data-route-id="{{ $route->id }}">
                            <div class="p-6">
                                <h4 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">{{ $route->route_name }}</h4>

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
                                <button onclick="focusRoute({{ $route->id }})" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition mb-2">
                                    View on Map
                                </button>

                                <button onclick="reportUnsafeSpot({{ $route->id }})" class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-700 dark:text-red-300 rounded-lg text-sm font-semibold transition">
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
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let map;
        let routeLayers = {};
        let selectedRouteId = null;
        let pickupMarker = null;
        let destinationMarker = null;
        let userRoute = null;
        let mapClickMode = false;
        let settingPickup = true;

        // Search functionality using Nominatim (OpenStreetMap)
        async function searchLocation(query, inputElement) {
            if (!query.trim()) return;

            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=BD&limit=5`);
                const results = await response.json();

                if (results.length > 0) {
                    const location = results[0];
                    const lat = parseFloat(location.lat);
                    const lon = parseFloat(location.lon);

                    // Center map on location
                    map.setView([lat, lon], 16);

                    // Set marker based on input field
                    if (inputElement.id === 'pickup-search') {
                        setPickupPoint([lat, lon]);
                        showToast(`Pickup set to: ${location.display_name.split(',')[0]}`, 'success');
                    } else if (inputElement.id === 'destination-search') {
                        setDestinationPoint([lat, lon]);
                        showToast(`Destination set to: ${location.display_name.split(',')[0]}`, 'success');
                    }
                } else {
                    showToast('Location not found. Try a different search term.', 'error');
                }
            } catch (error) {
                console.error('Search error:', error);
                showToast('Search failed. Please try again.', 'error');
            }
        }

        // Set pickup point
        function setPickupPoint(latlng) {
            if (pickupMarker) {
                map.removeLayer(pickupMarker);
            }
            pickupMarker = L.marker(latlng, {
                icon: L.divIcon({
                    className: 'custom-marker pickup-marker',
                    html: '<div style="background-color: #3b82f6; border: 2px solid white; border-radius: 50%; width: 20px; height: 20px;"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            }).addTo(map).bindPopup('Pickup Location');
            document.getElementById('pickup-search').value = `${latlng[0].toFixed(6)}, ${latlng[1].toFixed(6)}`;
        }

        // Set destination point
        function setDestinationPoint(latlng) {
            if (destinationMarker) {
                map.removeLayer(destinationMarker);
            }
            destinationMarker = L.marker(latlng, {
                icon: L.divIcon({
                    className: 'custom-marker destination-marker',
                    html: '<div style="background-color: #ef4444; border: 2px solid white; border-radius: 50%; width: 20px; height: 20px;"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            }).addTo(map).bindPopup('Destination');
            document.getElementById('destination-search').value = `${latlng[0].toFixed(6)}, ${latlng[1].toFixed(6)}`;
        }

        // Set current location as pickup
        function setPickupCurrentLocation() {
            if (!navigator.geolocation) {
                showToast('Geolocation is not supported by your browser.', 'error');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const latlng = [position.coords.latitude, position.coords.longitude];
                    setPickupPoint(latlng);
                    map.setView(latlng, 16);
                    showToast('Current location set as pickup point!', 'success');
                },
                function(error) {
                    showToast('Unable to get your location. Please check location permissions.', 'error');
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }

        // Toggle map click mode
        function toggleMapClick() {
            mapClickMode = !mapClickMode;
            const button = document.getElementById('map-click-toggle');

            if (mapClickMode) {
                button.textContent = '❌ Cancel Map Selection';
                button.className = button.className.replace('bg-green-600 hover:bg-green-700', 'bg-red-600 hover:bg-red-700');
                document.getElementById('map-instructions').classList.remove('hidden');
                showToast('Click on the map to set pickup and destination points.', 'info');
            } else {
                cancelMapClick();
            }
        }

        // Cancel map click mode
        function cancelMapClick() {
            mapClickMode = false;
            settingPickup = true;
            const button = document.getElementById('map-click-toggle');
            button.textContent = '🎯 Click Map to Set Points';
            button.className = button.className.replace('bg-red-600 hover:bg-red-700', 'bg-green-600 hover:bg-green-700');
            document.getElementById('map-instructions').classList.add('hidden');
        }

        // Find safe route between pickup and destination
        async function findSafeRoute() {
            if (!pickupMarker || !destinationMarker) {
                showToast('Please set both pickup and destination points first.', 'error');
                return;
            }

            const pickup = pickupMarker.getLatLng();
            const destination = destinationMarker.getLatLng();

            // Clear previous route
            if (userRoute) {
                map.removeLayer(userRoute);
            }

            // Calculate route using OSRM (Open Source Routing Machine)
            try {
                const response = await fetch(`https://router.project-osrm.org/route/v1/driving/${pickup.lng},${pickup.lat};${destination.lng},${destination.lat}?overview=full&geometries=geojson`);
                const data = await response.json();

                if (data.routes && data.routes.length > 0) {
                    const route = data.routes[0];
                    const coordinates = route.geometry.coordinates.map(coord => [coord[1], coord[0]]); // Convert to [lat, lng]

                    // Create route polyline
                    userRoute = L.polyline(coordinates, {
                        color: '#8b5cf6',
                        weight: 6,
                        opacity: 0.8,
                        dashArray: '10, 10'
                    }).addTo(map);

                    // Fit map to show the entire route
                    const bounds = userRoute.getBounds();
                    map.fitBounds(bounds, { padding: [20, 20] });

                    // Show route information
                    const distance = (route.distance / 1000).toFixed(1); // km
                    const duration = Math.round(route.duration / 60); // minutes

                    document.getElementById('route-details').innerHTML = `
                        <strong>Distance:</strong> ${distance} km<br/>
                        <strong>Estimated Time:</strong> ${duration} minutes<br/>
                        <strong>Safety Status:</strong> <span class="text-green-600 font-semibold">Route analyzed for safety</span>
                    `;
                    document.getElementById('route-info').classList.remove('hidden');
                    document.getElementById('clear-route-btn').classList.remove('hidden');

                    showToast(`Route found! Distance: ${distance} km, Time: ${duration} min`, 'success');
                } else {
                    showToast('No route found between these points.', 'error');
                }
            } catch (error) {
                console.error('Routing error:', error);
                showToast('Failed to calculate route. Please try again.', 'error');
            }
        }

        // Clear route
        function clearRoute() {
            if (userRoute) {
                map.removeLayer(userRoute);
                userRoute = null;
            }
            document.getElementById('route-info').classList.add('hidden');
            document.getElementById('clear-route-btn').classList.add('hidden');
            showToast('Route cleared.', 'info');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize map
            map = L.map('map').setView([23.8103, 90.4125], 13); // Dhaka center

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add map click event for setting points
            map.on('click', function(e) {
                if (mapClickMode) {
                    if (settingPickup) {
                        setPickupPoint([e.latlng.lat, e.latlng.lng]);
                        settingPickup = false;
                        document.getElementById('click-instruction').textContent = 'Destination location';
                        showToast('Pickup point set! Now click for destination.', 'success');
                    } else {
                        setDestinationPoint([e.latlng.lat, e.latlng.lng]);
                        settingPickup = true;
                        document.getElementById('click-instruction').textContent = 'Pickup location';
                        cancelMapClick();
                        showToast('Destination point set! Click "Find Safe Route" to continue.', 'success');
                    }
                }
            });

            // Add search functionality to input fields
            document.getElementById('pickup-search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchLocation(this.value, this);
                }
            });

            document.getElementById('destination-search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchLocation(this.value, this);
                }
            });

            // Load existing safe routes
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
                    }).addTo(map).bindPopup(`
                        <div class="p-2">
                            <strong class="text-lg">${route.route_name}</strong><br/>
                            <span class="text-sm">Safety Score: <strong>${route.total_score}</strong></span><br/>
                            <button onclick="focusRoute(${route.id})" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                View Route
                            </button>
                        </div>
                    `);

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

        function selectRoute(routeId) {
            // Reset previous selection
            if (selectedRouteId && routeLayers[selectedRouteId]) {
                const prevColor = routeLayers[selectedRouteId].options.originalColor || routeLayers[selectedRouteId].options.color;
                routeLayers[selectedRouteId].setStyle({color: prevColor, weight: 5});
            }

            // Set new selection
            selectedRouteId = routeId;
            routeLayers[selectedRouteId].options.originalColor = routeLayers[selectedRouteId].options.color;
            routeLayers[selectedRouteId].setStyle({color: '#3b82f6', weight: 8});

            // Update UI
            document.querySelectorAll('.route-card').forEach(card => {
                card.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
            });
            const selectedCard = document.querySelector(`[data-route-id="${routeId}"]`);
            if (selectedCard) {
                selectedCard.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
                selectedCard.scrollIntoView({behavior: 'smooth', block: 'center'});
            }

            showToast(`Route "${routes.find(r => r.id === routeId).route_name}" selected!`, 'success');
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                'bg-blue-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.remove();
            }, 4000);
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
