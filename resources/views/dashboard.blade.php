<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Safety Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-4xl">
            <!-- Welcome Card -->
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-700">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">
                    Welcome, {{ Auth::user()->name }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">
                    Your safety is our priority. In case of emergency, press the SOS button below.
                </p>
            </div>

            <!-- Main SOS Button Container -->
            <div class="flex flex-col items-center justify-center">
                <!-- SOS Status Card -->
                <div class="mb-8 w-full max-w-md">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center border border-gray-200 dark:border-gray-700">
                        <p class="text-gray-600 dark:text-gray-400 mb-2">Status</p>
                        <p id="status-text" class="text-2xl font-bold text-green-600 dark:text-green-400">Ready</p>
                    </div>
                </div>

                <!-- Giant SOS Button with Glassmorphism -->
                <div class="relative mb-8">
                    <!-- Pulsing background circles -->
                    <div class="absolute inset-0 w-96 h-96 bg-red-500/20 rounded-full animate-pulse blur-3xl -z-10"></div>
                    <div class="absolute inset-12 w-72 h-72 bg-red-400/20 rounded-full animate-pulse blur-2xl -z-10" style="animation-delay: 0.5s;"></div>

                    <!-- Main SOS Button -->
                    <button id="sos-btn" class="relative w-80 h-80 rounded-full font-black text-6xl text-white transition-all duration-300 hover:scale-105 active:scale-95 shadow-2xl
                        bg-gradient-to-br from-red-600 to-red-800 dark:from-red-700 dark:to-red-900
                        hover:from-red-700 hover:to-red-900 dark:hover:from-red-800 dark:hover:to-black
                        border-4 border-red-400 dark:border-red-600
                        focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800
                        backdrop-blur-md
                        flex items-center justify-center
                        overflow-hidden">

                        <!-- Ripple effect container -->
                        <div class="absolute inset-0 rounded-full" id="ripple-container"></div>

                        <!-- Button content -->
                        <div class="relative z-10 flex flex-col items-center">
                            <span class="block animate-bounce mb-2" style="animation: bounce 2s infinite;">🚨</span>
                            <span class="text-center leading-tight">SOS</span>
                        </div>
                    </button>
                </div>

                <!-- Loading spinner (hidden by default) -->
                <div id="loading-spinner" class="hidden mb-8">
                    <div class="w-16 h-16 border-4 border-gray-300 dark:border-gray-600 border-t-red-600 dark:border-t-red-500 rounded-full animate-spin"></div>
                </div>

                <!-- Instructions -->
                <div class="mt-8 w-full max-w-md bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                    <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-3">How to use:</h3>
                    <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                        <li class="flex items-start">
                            <span class="mr-3">📍</span>
                            <span>Your location will be shared with authorities</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-3">⚡</span>
                            <span>Alert will be sent to admin within seconds</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-3">📱</span>
                            <span>Keep the app open for best location accuracy</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="hidden fixed bottom-4 right-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 border border-gray-200 dark:border-gray-700 max-w-sm z-50">
        <div class="flex items-start">
            <span id="toast-icon" class="text-2xl mr-3"></span>
            <div>
                <h3 id="toast-title" class="font-semibold text-gray-900 dark:text-white"></h3>
                <p id="toast-message" class="text-sm text-gray-600 dark:text-gray-400 mt-1"></p>
            </div>
        </div>
    </div>

    <!-- Styles for animations -->
    <style>
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        .ripple {
            animation: ripple 0.6s ease-out;
            position: absolute;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
        }

        @media (max-width: 768px) {
            #sos-btn {
                width: 15rem;
                height: 15rem;
            }

            #sos-btn {
                font-size: 2.5rem;
            }

            .absolute.inset-0.w-96.h-96 {
                width: 20rem !important;
                height: 20rem !important;
            }

            .absolute.inset-12.w-72.h-72 {
                width: 16rem !important;
                height: 16rem !important;
            }
        }
    </style>

    <script src="{{ asset('js/sos-button.js') }}"></script>
</x-app-layout>
