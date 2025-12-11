@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-pink-700">🌺 Women-Only Forum 🌺</h2>
        <a href="{{ route('forum.create') }}" class="bg-pink-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-pink-700 transition duration-150 shadow-md">
            <i class="fas fa-plus-circle"></i> Create New Post
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 mb-4 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="space-y-4">
        @forelse($posts as $post)
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
                <h3 class="text-xl font-extrabold mb-1">
                    <a href="{{ route('forum.show', $post) }}" class="text-gray-800 hover:text-pink-600 transition duration-150">
                        {{ $post->title }}
                    </a>
                </h3>
                
                <p class="text-gray-500 text-sm mt-1">
                    Posted by: **{{ $post->user->name }}** • 
                    Time: {{ $post->created_at->diffForHumans() }}
                </p>
                
                <p class="mt-3 text-gray-700 leading-relaxed">
                    {{ Str::limit($post->body, 150) }}
                </p>
                
                <div class="mt-3 pt-2 border-t border-gray-100 flex justify-end">
                    <span class="text-pink-600 font-semibold text-sm">
                         💬 Replies: {{ $post->replies->count() }}
                    </span>
                </div>
            </div>
        @empty
            <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 p-6 rounded-lg text-center shadow-lg">
                <p class="font-bold mb-2">No posts found in this forum.</p>
                <p>Be the first to create a discussion!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination Link --}}
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection