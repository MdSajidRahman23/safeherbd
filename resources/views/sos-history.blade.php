<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My SOS History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold">Your Emergency SOS Alerts</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">View all your SOS alerts and their status</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Back to Dashboard
                        </a>
                    </div>

                    @if($alerts->count() > 0)
                        <div class="space-y-4">
                            @foreach($alerts as $alert)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="flex items-center gap-2">
                                                    @if($alert->status === 'pending')
                                                        <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                                                        <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Pending</span>
                                                    @elseif($alert->status === 'responded')
                                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Responded</span>
                                                    @elseif($alert->status === 'resolved')
                                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Resolved</span>
                                                    @else
                                                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ ucfirst($alert->status) }}</span>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $alert->created_at->format('M d, Y \a\t h:i A') }}
                                                </span>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                                <div>
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Location:</span>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                        📍 {{ number_format($alert->latitude, 6) }}, {{ number_format($alert->longitude, 6) }}
                                                    </p>
                                                </div>
                                                @if($alert->message)
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Message:</span>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 italic">
                                                            "{{ $alert->message }}"
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>

                                            @if($alert->status !== 'pending')
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                                    Last updated: {{ $alert->updated_at->format('M d, Y \a\t h:i A') }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-4">
                                            <button onclick="showOnMap({{ $alert->latitude }}, {{ $alert->longitude }})"
                                                    class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded text-xs font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                                🗺️ View Location
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $alerts->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No SOS Alerts Yet</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">You haven't sent any emergency SOS alerts. Your safety history will appear here.</p>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                🆘 Go to Dashboard
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Map View -->
    <div id="map-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">SOS Location</h3>
                <button onclick="closeMapModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="location-map" style="height: 400px;" class="rounded-lg"></div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let locationMap = null;

        function showOnMap(lat, lng) {
            document.getElementById('map-modal').classList.remove('hidden');

            if (locationMap) {
                locationMap.remove();
            }

            locationMap = L.map('location-map').setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(locationMap);

            // Add marker at SOS location
            L.marker([lat, lng], {
                icon: L.divIcon({
                    className: 'custom-marker sos-marker',
                    html: '<div style="background-color: #ef4444; border: 3px solid white; border-radius: 50%; width: 24px; height: 24px; box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);"></div>',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                })
            }).addTo(locationMap).bindPopup('<strong>🚨 SOS Alert Location</strong><br/>Emergency alert sent from this location');

            // Add circle to show approximate area
            L.circle([lat, lng], {
                color: '#ef4444',
                fillColor: '#ef4444',
                fillOpacity: 0.1,
                radius: 100
            }).addTo(locationMap);
        }

        function closeMapModal() {
            document.getElementById('map-modal').classList.add('hidden');
            if (locationMap) {
                locationMap.remove();
                locationMap = null;
            }
        }

        // Close modal when clicking outside
        document.getElementById('map-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeMapModal();
            }
        });
    </script>
</x-app-layout>