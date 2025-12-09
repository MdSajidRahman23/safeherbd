@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-pink-600">Women-Only Forum</h2>
        <a href="{{ route('forum.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded">Create New Post</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid gap-4">
        @foreach($posts as $post)
            <div class="bg-white p-6 rounded shadow hover:shadow-md transition">
                <h3 class="text-xl font-bold">
                    <a href="{{ route('forum.show', $post->id) }}" class="hover:text-pink-500">{{ $post->title }}</a>
                </h3>
                <p class="text-gray-600 text-sm mt-1">
                    By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                </p>
                <p class="mt-3 text-gray-700">{{ Str::limit($post->body, 100) }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection

