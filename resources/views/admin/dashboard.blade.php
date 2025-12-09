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
                    Welcome Admin! SOS Alerts Summary Here.
                    
                    @if(isset($alerts))
                        <h3 class="text-lg font-bold mt-4">Recent SOS Alerts</h3>
                        <ul>
                            @foreach ($alerts as $alert)
                                <li>
                                    Alert ID: {{ $alert->id }} (Status: {{ $alert->status }}) by {{ $alert->user->name ?? 'N/A' }} 
                                    at (Lat: {{ $alert->latitude }}, Lon: {{ $alert->longitude }})
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>