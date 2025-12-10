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

                    <div class="mt-8 flex items-center justify-center">
                        <div id="sos-button-wrapper" class="relative">
                            <button id="sos-button" title="Send SOS" class="sos-btn w-56 h-56 rounded-full flex items-center justify-center text-white text-2xl font-extrabold shadow-2xl transition-transform transform hover:scale-105 focus:outline-none">
                                <span class="sr-only">Send SOS</span>
                                <div class="pulse absolute inset-0 rounded-full"></div>
                                <span class="relative z-10">SOS</span>
                            </button>
                        </div>
                    </div>

                    <script src="/js/sos-button.js" defer></script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
