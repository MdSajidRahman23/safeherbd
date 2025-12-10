<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SOS Alerts History') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div id="map" style="height: 520px;" class="rounded-lg"></div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Alerts</p>
                    <p class="text-3xl font-bold mt-2">{{ $alerts->total() }}</p>

                    <div class="mt-6 space-y-4">
                        <a href="{{ route('admin.sos-history') }}" class="block text-sm text-blue-600 dark:text-blue-400 hover:underline">View Full List</a>
                    </div>
                </div>
            </div>

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
                                                <span class="text-red-600 dark:text-red-400 font-bold">{{ optional($alert->user)->name ? substr($alert->user->name, 0, 1) : 'U' }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $alert->user->name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $alert->user->email ?? '' }}</p>
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
                                            {{ \Illuminate\Support\Str::limit($alert->message, 100) }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $alert->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($alert->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
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

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    <script>
        window.INITIAL_SOS = @json($alerts->items());
    </script>
    <script src="/js/admin-sos-map.js" defer></script>

</x-app-layout>
