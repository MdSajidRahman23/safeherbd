<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <div class="mt-6">
                        <h3 class="text-lg font-bold mb-4">Emergency SOS</h3>
                        <p class="mb-4">If you need immediate assistance, click the SOS button below. Your location will be captured automatically.</p>

                        <button id="sos-button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-full text-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                            🚨 SOS 🚨
                        </button>

                        <div id="sos-status" class="mt-4 text-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('sos-button').addEventListener('click', function() {
            const button = this;
            const statusDiv = document.getElementById('sos-status');

            button.disabled = true;
            button.textContent = 'Getting Location...';
            statusDiv.textContent = '';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    button.textContent = 'Sending SOS...';

                    fetch('/sos/alert', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            latitude: latitude,
                            longitude: longitude,
                            message: 'Immediate assistance required.'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            statusDiv.innerHTML = '<span class="text-green-600 font-bold">✓ ' + data.message + '</span>';
                            button.textContent = 'SOS Sent';
                            button.classList.remove('bg-red-600', 'hover:bg-red-700');
                            button.classList.add('bg-green-600');
                        } else {
                            throw new Error('Failed to send SOS');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        statusDiv.innerHTML = '<span class="text-red-600 font-bold">✗ Failed to send SOS. Please try again.</span>';
                        button.disabled = false;
                        button.textContent = '🚨 SOS 🚨';
                    });
                }, function(error) {
                    console.error('Geolocation error:', error);
                    statusDiv.innerHTML = '<span class="text-red-600 font-bold">✗ Unable to get your location. Please enable location services and try again.</span>';
                    button.disabled = false;
                    button.textContent = '🚨 SOS 🚨';
                });
            } else {
                statusDiv.innerHTML = '<span class="text-red-600 font-bold">✗ Geolocation is not supported by this browser.</span>';
                button.disabled = false;
                button.textContent = '🚨 SOS 🚨';
            }
        });
    </script>
</x-app-layout>
