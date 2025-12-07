@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-2xl">
    <h2 class="text-2xl font-bold mb-4">Create a Discussion</h2>

    <form action="{{ route('forum.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label class="block font-bold mb-1">Title</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">Body</label>
            <textarea name="body" rows="5" class="w-full border p-2 rounded" required></textarea>
        </div>

        <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
            Post Discussion
        </button>
    </form>
</div>
@endsection
