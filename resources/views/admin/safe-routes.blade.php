<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Safe Routes Management') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Safe Routes Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold dark:text-gray-200">Safe Routes Summary</h3>
                    <a href="{{ route('admin.safe-routes.create') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                        Add New Route
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 dark:bg-green-900 rounded p-4">
                        <h4 class="text-sm text-green-600 dark:text-green-400">Total Routes</h4>
                        <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $safeRoutes->count() }}</p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900 rounded p-4">
                        <h4 class="text-sm text-blue-600 dark:text-blue-400">Active Routes</h4>
                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $safeRoutes->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900 rounded p-4">
                        <h4 class="text-sm text-purple-600 dark:text-purple-400">Avg Safety Score</h4>
                        <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">
                            @if($safeRoutes->count() > 0)
                                {{ round($safeRoutes->avg('total_score'), 1) }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Safe Routes Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-bold dark:text-gray-200">All Safe Routes</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Route Name</th>
                                <th class="py-3 px-4 text-left">Safety Score</th>
                                <th class="py-3 px-4 text-left">Created By</th>
                                <th class="py-3 px-4 text-left">Created</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @forelse ($safeRoutes as $route)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-3 px-4">{{ $route->id }}</td>
                                    <td class="py-3 px-4">{{ $route->route_name }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $route->total_score <= 2 ? 'bg-green-500 text-white' : ($route->total_score <= 5 ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                            {{ $route->total_score }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">{{ $route->creator->name ?? 'Unknown' }}</td>
                                    <td class="py-3 px-4">{{ $route->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.safe-routes.edit', $route->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.safe-routes.destroy', $route->id) }}" class="inline" onsubmit="return confirm('Delete this route?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-500 dark:text-gray-400">
                                        No safe routes found. <a href="{{ route('admin.safe-routes.create') }}" class="text-blue-500 hover:underline">Create one now</a>.
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
</x-app-layout>
