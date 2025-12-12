
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-sm text-gray-500 dark:text-gray-400">Total Users</h3>
                    <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalUsers ?? 0 }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-sm text-gray-500 dark:text-gray-400">Safe Routes</h3>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $totalRoutes ?? 0 }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-sm text-gray-500 dark:text-gray-400">SOS Alerts</h3>
                    <p id="live-sos-count" class="text-4xl font-bold text-red-600 mt-2">{{ $totalSos ?? 0 }}</p>
                </div>
            </div>


            <!-- SOS Alerts History -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
                <h3 class="text-lg font-bold mb-4 dark:text-gray-200">SOS Alerts History</h3>
                <div class="overflow-x-auto">
                    @if(isset($alerts) && count($alerts) > 0)
                        <table class="w-full text-sm">

                                <tr>
                                    <th class="py-3 px-4 text-left">ID</th>
                                    <th class="py-3 px-4 text-left">User</th>
                                    <th class="py-3 px-4 text-left">Location</th>
                                    <th class="py-3 px-4 text-left">Message</th>
                                    <th class="py-3 px-4 text-left">Status</th>
                                    <th class="py-3 px-4 text-left">Created At</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="alerts-table-body" class="divide-y dark:divide-gray-700">
                                @foreach ($alerts as $alert)
                                    <tr id="alert-{{ $alert->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4">{{ $alert->id }}</td>
                                        <td class="py-3 px-4">{{ $alert->user_name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ number_format($alert->latitude, 5) }}, {{ number_format($alert->longitude, 5) }}</td>
                                        <td class="py-3 px-4 truncate">{{ $alert->message ?? '-' }}</td>
                                        <td class="py-3 px-4">
                                            <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                                {{ $alert->status === 'acknowledged' ? 'bg-green-500' : 'bg-red-500' }}">
                                                {{ ucfirst($alert->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($alert->created_at)->format('Y-m-d H:i') }}</td>
                                        <td class="py-3 px-4">
                                            @if($alert->status === 'pending')
                                                <button onclick="updateAlertStatus({{ $alert->id }}, 'acknowledged')" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                                    Acknowledge
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">No SOS alerts yet.</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4 dark:text-gray-200">Quick Actions</h3>
                <div class="flex gap-4 flex-wrap">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                        Manage Users
                    </a>
                    <a href="{{ route('admin.safe-routes.index') }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded">
                        Manage Routes
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded">
                        Review Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pusher Real-time Updates -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                Pusher.logToConsole = false;

                var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
                    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                    encrypted: true
                });

                var channel = pusher.subscribe('sos-alerts');
                channel.bind('SosAlertCreated', function(data) {
                    const liveCounter = document.getElementById('live-sos-count');
                    if (liveCounter) {
                        let currentCount = parseInt(liveCounter.textContent) || 0;
                        liveCounter.textContent = currentCount + 1;
                    }

                    // Add new alert to table if it exists
                    const tbody = document.getElementById('alerts-table-body');
                    if (tbody && data.alert) {
                        const newRow = document.createElement('tr');
                        newRow.id = 'alert-' + data.alert.id;
                        newRow.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
                        newRow.innerHTML = `
                            <td class="py-3 px-4">${data.alert.id}</td>
                            <td class="py-3 px-4">${data.alert.user ? data.alert.user.name : 'N/A'}</td>
                            <td class="py-3 px-4">${data.alert.latitude}, ${data.alert.longitude}</td>
                            <td class="py-3 px-4 truncate">${data.alert.message || '-'}</td>
                            <td class="py-3 px-4"><span class="px-2 py-1 rounded text-white text-xs font-semibold bg-red-500">Pending</span></td>
                            <td class="py-3 px-4">${new Date().toLocaleString()}</td>
                            <td class="py-3 px-4"><button onclick="updateAlertStatus(${data.alert.id}, 'acknowledged')" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">Acknowledge</button></td>
                        `;
                        tbody.insertBefore(newRow, tbody.firstChild);
                    }

                    // Show desktop notification
                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification('New SOS Alert!', {
                            body: `From ${data.alert.user ? data.alert.user.name : 'Unknown'} at ${data.alert.latitude}, ${data.alert.longitude}`,
                            icon: '/favicon.ico',
                            tag: 'sos-alert'
                        });
                    }
                });
            } catch (e) {
                console.warn('Realtime updates not available:', e);
            }
        });

        function updateAlertStatus(alertId, newStatus) {
            if (confirm(`Update alert status to ${newStatus}?`)) {
                fetch(`/admin/alerts/${alertId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        const row = document.getElementById('alert-' + alertId);
                        if (row) {
                            const statusCell = row.querySelector('td:nth-child(5)');
                            const actionCell = row.querySelector('td:nth-child(7)');
                            statusCell.innerHTML = '<span class="px-2 py-1 rounded text-white text-xs font-semibold bg-green-500">Acknowledged</span>';
                            actionCell.innerHTML = '';
                        }
                    }
                });
            }
        }

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    </script>
</x-app-layout>
