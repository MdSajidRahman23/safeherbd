<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Women-Only Forum') }}
            </h2>
            <a href="{{ route('forum.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                {{ __('Create Post') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($posts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-lg font-bold mb-1">
                                    <a href="{{ route('forum.show', $post) }}" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    By <strong>{{ $post->user->name }}</strong> • {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @if(Auth::id() === $post->user_id)
                                <div class="flex gap-2">
                                    <a href="{{ route('forum.edit', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                    <form action="{{ route('forum.destroy', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <p class="text-gray-700 dark:text-gray-300 mb-3 line-clamp-2">{{ $post->body }}</p>

                        <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-700">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                💬 {{ $post->replies->count() }} {{ __('Replies') }}
                            </span>
                            <a href="{{ route('forum.show', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                {{ __('View Discussion') }} →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-300 dark:border-yellow-700 rounded-lg p-8 text-center">
                        <p class="text-yellow-800 dark:text-yellow-200 font-semibold mb-2">No posts yet</p>
                        <p class="text-yellow-700 dark:text-yellow-300 text-sm">Be the first to start a discussion!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>