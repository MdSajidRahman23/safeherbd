<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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