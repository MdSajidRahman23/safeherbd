@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">

    <!-- Post -->
    <div class="bg-white p-6 rounded shadow mb-6 border-l-4 border-pink-500">
        <div class="flex justify-between">
            <h1 class="text-3xl font-bold">{{ $post->title }}</h1>

            <form action="{{ route('forum.report', $post->id) }}"
                  method="POST"
                  onsubmit="return confirm('Report this post?');">
                @csrf
                <button type="submit" class="text-red-500 text-sm underline">Report</button>
            </form>
        </div>

        <p class="text-gray-500 text-sm mb-4">
            Posted by {{ $post->user->name }}
            on {{ $post->created_at->format('M d, Y h:i A') }}
        </p>

        <div class="prose max-w-none text-gray-800">
            {{ $post->body }}
        </div>

        @if(Auth::id() === $post->user_id)
            <form action="{{ route('forum.destroy', $post->id) }}" 
                  method="POST" class="mt-4">
                @csrf 
                @method('DELETE')
                <button class="text-red-600 text-sm">Delete My Post</button>
            </form>
        @endif
    </div>

    <!-- Replies -->
    <div class="mt-8">
        <h3 class="text-xl font-bold mb-4">Replies</h3>

        @foreach($post->replies as $reply)
            <div class="bg-gray-50 p-4 rounded mb-3 border border-gray-200">
                <div class="flex justify-between text-xs text-gray-500 mb-2">
                    <strong>{{ $reply->user->name }}</strong>
                    <span>{{ $reply->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-800">{{ $reply->reply_text }}</p>
            </div>
        @endforeach

        <form action="{{ route('forum.reply', $post->id) }}" method="POST" class="mt-6">
            @csrf
            <textarea name="reply_text" 
                      class="w-full border p-3 rounded mb-2"
                      placeholder="Write a supportive reply..."
                      required></textarea>

            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded text-sm">
                Post Reply
            </button>
        </form>
    </div>

</div>
@endsection
