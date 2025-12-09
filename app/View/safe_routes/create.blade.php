<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Safe Route
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('safe-routes.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700">Route Name</label>
                        <input type="text" name="route_name" class="w-full border border-gray-300 p-2 rounded mt-1" placeholder="Example: Road 1 to University" required>
                    </div>
                    
                    <input type="hidden" name="coordinates" value="[23.8103, 90.4125]">
                    
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700">Risk Score (Crime Points)</label>
                        <input type="number" name="crime_points" class="w-full border border-gray-300 p-2 rounded mt-1" placeholder="0 = Safe, 10 = Dangerous" required>
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Save Route
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>