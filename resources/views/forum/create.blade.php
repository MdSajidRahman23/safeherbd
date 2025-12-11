@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-6 max-w-2xl">
    <h2 class="text-3xl font-bold mb-6 text-center text-pink-700">📝 Create New Post</h2>

    {{-- Validation Errors Display --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('forum.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        @csrf

        {{-- Title Input --}}
        <div class="mb-4">
            <label for="title" class="block font-semibold mb-2 text-gray-700">Post Title:</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="w-full border-gray-300 border p-3 rounded-lg focus:border-pink-500 focus:ring-1 focus:ring-pink-500 @error('title') border-red-500 @enderror" 
                value="{{ old('title') }}" 
                required 
                maxlength="255"
                placeholder="Enter a brief and engaging title"
            >
             @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Body Content Input --}}
        <div class="mb-6">
            <label for="body" class="block font-semibold mb-2 text-gray-700">Post Body:</label>
            <textarea 
                id="body" 
                name="body" 
                rows="8" 
                class="w-full border-gray-300 border p-3 rounded-lg focus:border-pink-500 focus:ring-1 focus:ring-pink-500 @error('body') border-red-500 @enderror" 
                required 
                placeholder="Write your discussion or question in detail here..."
            >{{ old('body') }}</textarea>
            <small class="text-gray-500 text-sm mt-1 block">Please use respectful language. Offensive content may be automatically filtered.</small>
            @error('body')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('forum.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-150">
                Cancel
            </a>
            <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-pink-700 transition duration-150 shadow-md">
                Post Discussion
            </button>
        </div>
    </form>
</div>
@endsection