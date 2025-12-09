<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
