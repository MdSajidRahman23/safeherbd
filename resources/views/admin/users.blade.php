<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Users Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold mb-4 dark:text-gray-200">Users Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900 rounded p-4">
                        <h4 class="text-sm text-blue-600 dark:text-blue-400">Total Users</h4>
                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $users->count() }}</p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900 rounded p-4">
                        <h4 class="text-sm text-green-600 dark:text-green-400">Active</h4>
                        <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $users->where('is_blocked', false)->count() }}</p>
                    </div>
                    <div class="bg-red-50 dark:bg-red-900 rounded p-4">
                        <h4 class="text-sm text-red-600 dark:text-red-400">Blocked</h4>
                        <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $users->where('is_blocked', true)->count() }}</p>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900 rounded p-4">
                        <h4 class="text-sm text-purple-600 dark:text-purple-400">Women</h4>
                        <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ $users->where('gender', 'female')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-bold dark:text-gray-200">All Users</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-left">Gender</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Joined</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-3 px-4">{{ $user->id }}</td>
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4">{{ $user->email }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $user->gender === 'female' ? 'bg-pink-500 text-white' : 'bg-blue-500 text-white' }}">
                                            {{ ucfirst($user->gender ?? 'Not Set') }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $user->is_blocked ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                                            {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex gap-2">
                                            @if(!$user->is_blocked)
                                                <form method="POST" action="{{ route('admin.users.block', $user->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs" onclick="return confirm('Block this user?')">
                                                        Block
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.unblock', $user->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                                        Unblock
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Delete this user? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
