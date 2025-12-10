<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SOS Alerts History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Map Container -->
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div id="map" style="height: 500px;" class="rounded-lg"></div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Total Alerts</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $alerts->total() }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Pending</p>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">{{ $alerts->where('status', 'pending')->count() }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Resolved</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $alerts->where('status', 'resolved')->count() }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Today</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $alerts->where('created_at', '>=', now()->startOfDay())->count() }}</p>
                </div>
            </div>

            <!-- Alerts Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Message</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($alerts as $alert)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                                                <span class="text-red-600 dark:text-red-400 font-bold">{{ substr($alert->user->name, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $alert->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $alert->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="https://maps.google.com/?q={{ $alert->latitude }},{{ $alert->longitude }}" 
                                           target="_blank"
                                           class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-mono">
                                            {{ number_format($alert->latitude, 4) }}, {{ number_format($alert->longitude, 4) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate max-w-xs">
                                            {{ $alert->message ?? 'No message' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($alert->status === 'pending')
                                                bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                            @elseif($alert->status === 'resolved')
                                                bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                            @else
                                                bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                            @endif">
                                            {{ ucfirst($alert->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $alert->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No SOS alerts yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($alerts->hasPages())
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        {{ $alerts->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    <script>
        // Initialize map
        const map = L.map('map').setView([23.6345, 90.3563], 12); // Centered on Dhaka

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Create marker cluster group
        const markers = L.markerClusterGroup({
            maxClusterRadius: 80,
            disableClusteringAtZoom: 16
        });

        // Add markers for all alerts
        const alerts = @json($alerts->items());
        const sosIcon = L.icon({
            iconUrl: 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red"><circle cx="12" cy="12" r="12"/><text x="12" y="16" font-size="12" font-weight="bold" text-anchor="middle" fill="white">SOS</text></svg>',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        alerts.forEach(alert => {
            const marker = L.marker([parseFloat(alert.latitude), parseFloat(alert.longitude)], {
                icon: sosIcon
            });

            const statusColor = alert.status === 'pending' ? 'text-yellow-600' : alert.status === 'resolved' ? 'text-green-600' : 'text-red-600';

            const popupContent = `
                <div class="p-3 max-w-xs">
                    <h3 class="font-bold text-gray-900">${alert.user.name}</h3>
                    <p class="text-sm text-gray-600 mb-2">${alert.user.email}</p>
                    <p class="text-sm mb-2"><strong>Status:</strong> <span class="${statusColor}">${alert.status.toUpperCase()}</span></p>
                    <p class="text-sm"><strong>Time:</strong> ${new Date(alert.created_at).toLocaleString()}</p>
                    ${alert.message ? `<p class="text-sm mt-2"><strong>Message:</strong> ${alert.message}</p>` : ''}
                    <a href="https://maps.google.com/?q=${alert.latitude},${alert.longitude}" target="_blank" class="text-blue-600 text-sm mt-2 inline-block hover:underline">
                        📍 View in Google Maps
                    </a>
                </div>
            `;

            marker.bindPopup(popupContent);
            markers.addLayer(marker);
        });

        map.addLayer(markers);

        // Fit map to show all markers
        if (alerts.length > 0) {
            map.fitBounds(markers.getBounds().pad(0.1));
        }
    </script>
</x-app-layout>
