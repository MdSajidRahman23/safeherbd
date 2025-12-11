<div class="relative">
    <div id="map" class="w-full h-96 lg:h-[500px] rounded-2xl overflow-hidden border border-white/20"></div>

    <!-- Loading spinner -->
    <div id="map-loading" class="absolute inset-0 flex items-center justify-center bg-black/30 hidden">
        <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 flex items-center space-x-3">
            <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span class="text-white font-medium">Loading map...</span>
        </div>
    </div>

    <!-- Legend -->
    <div class="absolute bottom-4 left-4 bg-white/10 backdrop-blur-md rounded-lg p-3 text-sm text-white border border-white/20 shadow-lg">
        <div class="flex items-center space-x-3">
            <span class="w-3 h-3 rounded-full" style="background:#10B981"></span>
            <span>Safe (70+)</span>
        </div>
        <div class="flex items-center space-x-3 mt-2">
            <span class="w-3 h-3 rounded-full" style="background:#F59E0B"></span>
            <span>Moderate (40-69)</span>
        </div>
        <div class="flex items-center space-x-3 mt-2">
            <span class="w-3 h-3 rounded-full" style="background:#EF4444"></span>
            <span>Risky (&lt;40)</span>
        </div>
    </div>
</div>
