<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Discussion') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                @if($errors->any())
                    <div class="mb-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg">
                        <strong>{{ __('Validation Error:') }}</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('forum.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Title Input -->
                    <div>
                        <label for="title" class="block font-semibold mb-2 text-gray-900 dark:text-white">
                            {{ __('Post Title') }}
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror" 
                            value="{{ old('title') }}" 
                            required 
                            maxlength="255"
                            placeholder="Enter a clear and descriptive title"
                        >
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Body Content Input -->
                    <div>
                        <label for="body" class="block font-semibold mb-2 text-gray-900 dark:text-white">
                            {{ __('Description') }}
                        </label>
                        <textarea 
                            id="body" 
                            name="body" 
                            rows="8" 
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('body') border-red-500 @enderror" 
                            required 
                            placeholder="Share your thoughts, questions, or experiences in detail..."
                        >{{ old('body') }}</textarea>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                            {{ __('Please use respectful language. Harmful content may be automatically filtered.') }}
                        </p>
                        @error('body')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('forum.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                            {{ __('Post Discussion') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>