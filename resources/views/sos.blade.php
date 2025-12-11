<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Emergency SOS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center p-10">
                
                <h3 class="text-2xl font-bold text-red-600 mb-6">Are you in Danger?</h3>
                <p class="mb-8 text-gray-600">Press the button below to send your live location to the admin.</p>

                <button id="sosBtn" class="relative inline-flex items-center justify-center w-48 h-48 bg-red-600 rounded-full hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 shadow-2xl transition-transform transform hover:scale-105 active:scale-95">
                    <span class="absolute w-full h-full rounded-full bg-red-500 opacity-75 animate-ping"></span>
                    <span class="relative text-4xl font-bold text-white">SOS</span>
                </button>

                <div id="statusMsg" class="mt-6 text-lg font-semibold text-gray-700"></div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('sosBtn').addEventListener('click', function() {
            const status = document.getElementById('statusMsg');
            status.innerText = "📍 Getting your GPS Location...";
            status.className = "mt-6 text-lg font-bold text-blue-600";

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendLocationToDatabase, showError);
            } else {
                status.innerText = "❌ Geolocation is not supported by this browser.";
            }
        });

        function sendLocationToDatabase(position) {
            const lat = position.coords.latitude;
            const long = position.coords.longitude;
            const status = document.getElementById('statusMsg');

            status.innerText = "⏳ Location Found! Sending Alert...";
            status.className = "mt-6 text-lg font-bold text-yellow-600";

            // AJAX Request to Server
            fetch("{{ route('sos.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: long,
                    message: "Emergency! I need help!"
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    status.innerText = "✅ HELP SENT! Admin has received your location.";
                    status.className = "mt-6 text-lg font-bold text-green-600";
                    alert("SOS Alert Sent Successfully!");
                } else {
                    status.innerText = "❌ Failed to send alert.";
                    status.className = "mt-6 text-lg font-bold text-red-600";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                status.innerText = "❌ Network Error. Please call 999.";
                status.className = "mt-6 text-lg font-bold text-red-600";
            });
        }

        function showError(error) {
            document.getElementById('statusMsg').innerText = "❌ GPS Error: " + error.message;
        }
    </script>
</x-app-layout>