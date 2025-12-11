<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-sm text-gray-500">Live SOS Count</h3>
                    <p id="live-sos-count" class="text-3xl font-bold mt-2">0</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-sm text-gray-500">Recent Alerts</h3>
                    <p class="mt-2">Quick access to latest SOS alerts.</p>
                    <a href="{{ route('admin.sos-history') }}" class="inline-block mt-4 text-sm text-blue-600 hover:underline">View history</a>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-sm text-gray-500">Actions</h3>
                    <p class="mt-2">Manage active alerts and settings.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple placeholder for live count — will be replaced by Echo in final integration
        document.addEventListener('DOMContentLoaded', function () {
            fetch('{{ route('admin.sos-history') }}')
                .then(r => r.text())
                .then(() => {
                    // placeholder; real-time will update via Echo
                });
        });
    </script>
    <!-- Pusher + Echo (CDN) -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.0/dist/echo.iife.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                Pusher.logToConsole = false;

                const echo = new window.Echo({
                    broadcaster: 'pusher',
                    key: '{{ env('PUSHER_APP_KEY') }}',
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                    forceTLS: true,
                    auth: {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }
                });

                const liveCounter = document.getElementById('live-sos-count');
                let count = 0;
                if (liveCounter) {
                    // Try to fetch an initial count from the server
                    fetch('{{ route('admin.sos-history') }}')
                        .then(r => r.json().catch(() => ({})))
                        .then(() => {
                            // No-op placeholder
                        });
                }

                echo.private('private-admin-sos')
                    .listen('SosAlertCreated', (e) => {
                        count += 1;
                        if (liveCounter) liveCounter.textContent = count;
                        alert('New SOS alert from ' + (e.user.name || 'Someone'));
                    });
            } catch (e) {
                console.warn('Realtime init failed', e);
            }
        });
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
<<<<<<< HEAD
            {{ __('Admin Dashboard') }}
=======
            Admin Dashboard
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<<<<<<< HEAD
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-gray-900 font-bold text-xl">Total Users</div>
                    <div class="text-4xl text-blue-600 font-bold mt-2">{{ $totalUsers }}</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-gray-900 font-bold text-xl">Safe Routes</div>
                    <div class="text-4xl text-green-600 font-bold mt-2">{{ $totalRoutes }}</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-gray-900 font-bold text-xl">SOS Alerts</div>
                    <div class="text-4xl text-red-600 font-bold mt-2">{{ $totalSos }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Quick Actions</h3>
                <a href="{{ route('admin.users.index') }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Manage Users
                </a>
                <a href="{{ route('admin.routes.index') }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 ml-2">
                    Manage Routes
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
=======
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">SOS Alerts History</h3>
                    <div id="alerts-container">
                        @if(isset($alerts) && $alerts->count() > 0)
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">ID</th>
                                        <th class="py-2 px-4 border-b">User</th>
                                        <th class="py-2 px-4 border-b">Location</th>
                                        <th class="py-2 px-4 border-b">Message</th>
                                        <th class="py-2 px-4 border-b">Status</th>
                                        <th class="py-2 px-4 border-b">Created At</th>
                                        <th class="py-2 px-4 border-b">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="alerts-table-body">
                                    @foreach ($alerts as $alert)
                                        <tr id="alert-{{ $alert->id }}">
                                            <td class="py-2 px-4 border-b">{{ $alert->id }}</td>
                                            <td class="py-2 px-4 border-b">{{ $alert->user->name ?? 'N/A' }}</td>
                                            <td class="py-2 px-4 border-b">{{ $alert->latitude }}, {{ $alert->longitude }}</td>
                                            <td class="py-2 px-4 border-b">{{ $alert->message }}</td>
                                            <td class="py-2 px-4 border-b">{{ $alert->status }}</td>
                                            <td class="py-2 px-4 border-b">{{ $alert->created_at->format('Y-m-d H:i') }}</td>
                                            <td class="py-2 px-4 border-b">
                                                @if($alert->status == 'Open')
                                                    <button onclick="closeAlert({{ $alert->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Close</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No SOS alerts yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}'
        });

        var channel = pusher.subscribe('sos-alerts');
        channel.bind('sos.alert.created', function(data) {
            console.log('New SOS alert:', data);
            // Add new alert to table
            var tbody = document.getElementById('alerts-table-body');
            var row = document.createElement('tr');
            row.id = 'alert-' + data.alert.id;
            row.innerHTML = `
                <td class="py-2 px-4 border-b">${data.alert.id}</td>
                <td class="py-2 px-4 border-b">${data.alert.user ? data.alert.user.name : 'N/A'}</td>
                <td class="py-2 px-4 border-b">${data.alert.latitude}, ${data.alert.longitude}</td>
                <td class="py-2 px-4 border-b">${data.alert.message}</td>
                <td class="py-2 px-4 border-b">${data.alert.status}</td>
                <td class="py-2 px-4 border-b">${new Date().toLocaleString()}</td>
                <td class="py-2 px-4 border-b">
                    <button onclick="closeAlert(${data.alert.id})" class="bg-red-500 text-white px-2 py-1 rounded">Close</button>
                </td>
            `;
            tbody.insertBefore(row, tbody.firstChild);

            // Show notification
            if (Notification.permission === 'granted') {
                new Notification('New SOS Alert!', {
                    body: `Alert from ${data.alert.user ? data.alert.user.name : 'Unknown'} at ${data.alert.latitude}, ${data.alert.longitude}`,
                    icon: '/favicon.ico'
                });
            }
        });

        // Request notification permission
        if (Notification.permission !== 'granted') {
            Notification.requestPermission();
        }

        function closeAlert(id) {
            if (confirm('Are you sure you want to close this alert?')) {
                fetch('/admin/alerts/' + id + '/close', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var row = document.getElementById('alert-' + id);
                        row.querySelector('td:nth-child(5)').textContent = 'Closed';
                        row.querySelector('td:nth-child(7)').innerHTML = '';
                    }
                });
            }
        }
    </script>
</x-app-layout>
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
