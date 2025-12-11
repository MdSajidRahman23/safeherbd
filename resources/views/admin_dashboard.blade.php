<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Control Panel - SOS Alerts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-red-600 mb-2">🚨 Recent SOS Alerts</h3>
                            <p class="text-sm text-gray-600">Monitor and respond to emergency alerts</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('my-sos-history') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                📋 My SOS History
                            </a>
                            <a href="{{ route('admin.sos-history') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                📊 All SOS History
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Time</th>
                                    <th class="py-3 px-6 text-left">User ID</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Location Map</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                
                                @foreach($alerts as $alert)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        {{ $alert->created_at->diffForHumans() }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <span class="font-bold">User #{{ $alert->user_id }}</span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">
                                            {{ $alert->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <a href="https://www.google.com/maps?q={{ $alert->latitude }},{{ $alert->longitude }}" target="_blank" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-700">
                                            🌍 View on Map
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    @if($alerts->isEmpty())
                        <p class="text-center text-gray-500 mt-4">No SOS alerts found. Everyone is safe! ✅</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>