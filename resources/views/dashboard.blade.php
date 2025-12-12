@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Message -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-2">{{ __('Welcome back, ') . (Auth::check() ? Auth::user()->name : 'Guest') }}!</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ __('Access all your safety features from here.') }}</p>
            </div>
        </div>

        <!-- Emergency SOS Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h4 class="text-xl font-bold text-red-600 mb-4 text-center">{{ __('🆘 Emergency SOS') }}</h4>
                <div class="flex items-center justify-center">
                    <div id="sos-button-wrapper" class="relative">
                        <button id="sos-button" title="Send SOS" class="sos-btn w-56 h-56 rounded-full flex items-center justify-center text-white text-2xl font-extrabold shadow-2xl transition-transform transform hover:scale-105 focus:outline-none bg-red-600 hover:bg-red-700">
                            <span class="sr-only">Send SOS</span>
                            <div class="pulse absolute inset-0 rounded-full bg-red-400 opacity-75"></div>
                            <span class="relative z-10">SOS</span>
                        </button>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('my-sos-history') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        📋 View SOS History
                    </a>
                </div>
                <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">{{ __('Tap to send emergency alert with your location') }}</p>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Forum Card (Women Only) -->
            @if(Auth::check() && Auth::user()->isFemale())
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-pink-100 dark:bg-pink-900 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Women\'s Forum') }}</h5>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('Connect with other women, share experiences, and get support.') }}</p>
                    <a href="{{ route('forum.index') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Enter Forum') }}
                    </a>
                </div>
            </div>
            @endif

            <!-- Chatbot Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('AI Chatbot') }}</h5>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('Get instant help and advice from our AI assistant.') }}</p>
                    <a href="{{ route('chatbot.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Start Chat') }}
                    </a>
                </div>
            </div>

            <!-- Safe Routes Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Safe Routes') }}</h5>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('View verified safe routes and report unsafe locations.') }}</p>
                    <a href="{{ route('safe-routes.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('View Routes') }}
                    </a>
                </div>
            </div>

            <!-- Admin Dashboard Card (Admin Only) -->
            @if(Auth::check() && Auth::user()->is_admin)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg md:col-span-2 lg:col-span-3">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Admin Control Panel') }}</h5>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('Manage SOS alerts, safe routes, users, and system settings.') }}</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Admin Dashboard') }}
                        </a>
                        <a href="{{ route('admin.sos-history') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('SOS History') }}
                        </a>
                        <a href="{{ route('admin.safe-routes.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Manage Routes') }}
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Quick Stats (if available) -->
        @if(Auth::check() && Auth::user()->is_admin)
        <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('Quick Stats') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ \App\Models\SosAlert::count() }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total SOS Alerts') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ \App\Models\User::where('gender', 'female')->count() }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Registered Women') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ \App\Models\SafeRoute::count() }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Safe Routes') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ \App\Models\ForumPost::count() }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Forum Posts') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script src="/js/sos-button.js" defer></script>
@endsection

            <!-- Emergency SOS Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-xl font-bold text-red-600 mb-4 text-center">{{ __('🆘 Emergency SOS') }}</h4>
                    <div class="flex items-center justify-center">
                        <div id="sos-button-wrapper" class="relative">
                            <button id="sos-button" title="Send SOS" class="sos-btn w-56 h-56 rounded-full flex items-center justify-center text-white text-2xl font-extrabold shadow-2xl transition-transform transform hover:scale-105 focus:outline-none bg-red-600 hover:bg-red-700">
                                <span class="sr-only">Send SOS</span>
                                <div class="pulse absolute inset-0 rounded-full bg-red-400 opacity-75"></div>
                                <span class="relative z-10">SOS</span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('my-sos-history') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            📋 View SOS History
                        </a>
                    </div>
                    <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">{{ __('Tap to send emergency alert with your location') }}</p>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Forum Card (Women Only) -->
                @if(Auth::check() && Auth::user()->isFemale())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-pink-100 dark:bg-pink-900 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Women\'s Forum') }}</h5>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('Connect with other women, share experiences, and get support.') }}</p>
                        <a href="{{ route('forum.index') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Enter Forum') }}
                        </a>
                    </div>
                </div>
                @endif

                <!-- Chatbot Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('AI Chatbot') }}</h5>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('Get instant help and advice from our AI assistant.') }}</p>
                        <a href="{{ route('chatbot.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Start Chat') }}
                        </a>
                    </div>
                </div>

                <!-- Safe Routes Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Safe Routes') }}</h5>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('View verified safe routes and report unsafe locations.') }}</p>
                        <a href="{{ route('safe-routes.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('View Routes') }}
                        </a>
                    </div>
                </div>

                <!-- Admin Dashboard Card (Admin Only) -->
                @if(Auth::check() && Auth::user()->is_admin)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg md:col-span-2 lg:col-span-3">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Admin Control Panel') }}</h5>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('Manage SOS alerts, safe routes, users, and system settings.') }}</p>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Admin Dashboard') }}
                            </a>
                            <a href="{{ route('admin.sos-history') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('SOS History') }}
                            </a>
                            <a href="{{ route('admin.safe-routes.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Manage Routes') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Stats (if available) -->
            @if(Auth::check() && Auth::user()->is_admin)
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('Quick Stats') }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ \App\Models\SosAlert::count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total SOS Alerts') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ \App\Models\User::where('gender', 'female')->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Registered Women') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ \App\Models\SafeRoute::count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Safe Routes') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ \App\Models\ForumPost::count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Forum Posts') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="/js/sos-button.js" defer></script>
</x-app-layout>
