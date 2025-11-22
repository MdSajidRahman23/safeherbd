<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Safe Routes List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('safe-routes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    + Add New Safe Route
                </a>
                
                <div class="mt-6">
                    <h3 class="text-lg font-bold mb-4">Available Routes:</h3>
                    @if($routes->isEmpty())
                        <p class="text-gray-500">No routes added yet.</p>
                    @else
                        <div class="grid gap-4">
                            @foreach($routes as $route)
                                <div class="border p-4 rounded bg-gray-50 flex justify-between items-center">
                                    <div>
                                        <h4 class="font-bold text-lg">{{ $route->route_name }}</h4>
                                        <p class="text-sm text-gray-600">Risk Score: <span class="font-bold {{ $route->total_score > 5 ? 'text-red-500' : 'text-green-500' }}">{{ $route->total_score }}</span></p>
                                    </div>
                                    <button class="text-blue-500 hover:underline">View on Map</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>