<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reports Management') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Reports Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold mb-4 dark:text-gray-200">Reports Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-orange-50 dark:bg-orange-900 rounded p-4">
                        <h4 class="text-sm text-orange-600 dark:text-orange-400">Total Reports</h4>
                        <p class="text-2xl font-bold text-orange-700 dark:text-orange-300">{{ $reports->count() }}</p>
                    </div>
                    <div class="bg-red-50 dark:bg-red-900 rounded p-4">
                        <h4 class="text-sm text-red-600 dark:text-red-400">Pending</h4>
                        <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $reports->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900 rounded p-4">
                        <h4 class="text-sm text-blue-600 dark:text-blue-400">Reviewed</h4>
                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $reports->where('status', 'reviewed')->count() }}</p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900 rounded p-4">
                        <h4 class="text-sm text-green-600 dark:text-green-400">Resolved</h4>
                        <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $reports->where('status', 'resolved')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-bold dark:text-gray-200">All Reports</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Post</th>
                                <th class="py-3 px-4 text-left">Reported By</th>
                                <th class="py-3 px-4 text-left">Reason</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Date</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @forelse ($reports as $report)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-3 px-4">{{ $report->id }}</td>
                                    <td class="py-3 px-4">
                                        <div class="max-w-xs">
                                            <p class="truncate font-medium">{{ $report->post->title ?? 'Post Deleted' }}</p>
                                            @if($report->post)
                                                <a href="{{ route('forum.show', $report->post) }}" class="text-blue-500 hover:underline text-xs">View Post</a>
                                            @else
                                                <span class="text-gray-400 text-xs">Post not found</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">{{ $report->reporter->name ?? 'Unknown' }}</td>
                                    <td class="py-3 px-4">
                                        <div class="max-w-xs">
                                            <p class="truncate">{{ $report->reason }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $report->status === 'pending' ? 'bg-red-500 text-white' : 
                                               ($report->status === 'reviewed' ? 'bg-blue-500 text-white' : 'bg-green-500 text-white') }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex gap-2">
                                            @if($report->status === 'pending')
                                                <button onclick="updateReportStatus({{ $report->id }}, 'reviewed')" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                                    Mark Reviewed
                                                </button>
                                                <button onclick="updateReportStatus({{ $report->id }}, 'resolved')" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                                    Resolve
                                                </button>
                                            @elseif($report->status === 'reviewed')
                                                <button onclick="updateReportStatus({{ $report->id }}, 'resolved')" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                                    Resolve
                                                </button>
                                            @endif
                                            <button onclick="deleteReport({{ $report->id }})" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-gray-500 dark:text-gray-400">
                                        No reports found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Back to Dashboard -->
            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        function updateReportStatus(reportId, newStatus) {
            if (confirm(`Update report status to ${newStatus}?`)) {
                fetch(`/admin/reports/${reportId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update report status.');
                    }
                }).catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred while updating the report status.');
                });
            }
        }

        function deleteReport(reportId) {
            if (confirm('Delete this report? This action cannot be undone.')) {
                fetch(`/admin/reports/${reportId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete report.');
                    }
                }).catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred while deleting the report.');
                });
            }
        }
    </script>
</x-app-layout>
