@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <a href="{{ route('forum.index') }}" class="text-pink-600 hover:text-pink-800 font-semibold mb-4 inline-block">
        <i class="fas fa-arrow-left mr-2"></i> ফোরামে ফিরে যান
    </a>

    {{-- সফল/ত্রুটি বার্তা --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 mb-4 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 mb-4 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-xl shadow-lg mb-6 border-l-4 border-pink-500">
        <div class="flex justify-between items-start">
            <h1 class="text-3xl font-extrabold text-gray-800">{{ $post->title }}</h1>
            
            {{-- রিপোর্ট বাটন (মোডাল ট্রিগার করবে) --}}
            <button type="button" class="text-red-500 text-sm hover:text-red-700 font-semibold underline" 
                    data-bs-toggle="modal" data-bs-target="#reportModal">
                <i class="fas fa-flag mr-1"></i> রিপোর্ট করুন
            </button>
        </div>

        <p class="text-gray-500 text-sm mb-4 mt-1">
            পোস্ট করেছেন: **{{ $post->user->name }}** • 
            সময়: {{ $post->created_at->format('d M, Y h:i A') }}
        </p>

        <div class="prose max-w-none text-gray-800 border-t pt-4 mt-4">
            {{-- nl2br ব্যবহার করে লাইন ব্রেক ঠিক রাখা --}}
            {!! nl2br(e($post->body)) !!} 
        </div>

        {{-- মালিকের জন্য অ্যাকশন বাটন --}}
        @if(Auth::check() && Auth::id() === $post->user_id)
            <div class="mt-4 pt-3 border-t border-gray-100 flex gap-3">
                <a href="{{ route('forum.edit', $post) }}" class="text-sm bg-pink-100 text-pink-600 px-3 py-1 rounded hover:bg-pink-200 font-semibold transition">
                    <i class="fas fa-edit mr-1"></i> এডিট করুন
                </a>
                
                <form action="{{ route('forum.destroy', $post) }}" method="POST" class="d-inline">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="text-sm bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 font-semibold transition"
                            onclick="return confirm('আপনি কি নিশ্চিত? পোস্টটি এবং এর সব রিপ্লাই ডিলেট হয়ে যাবে।')">
                        <i class="fas fa-trash-alt mr-1"></i> পোস্ট ডিলেট করুন
                    </button>
                </form>
            </div>
        @endif
    </div>

    <div class="mt-8">
        <h3 class="text-2xl font-bold mb-4 text-pink-700">💬 রিপ্লাই ({{ $post->replies->count() }})</h3>

        {{-- রিপ্লাই ফর্ম --}}
        @if (Auth::check())
            <form action="{{ route('forum.reply.store', $post) }}" method="POST" class="mt-6 bg-white p-4 rounded-xl shadow-md mb-6">
                @csrf
                <textarea name="reply_text" 
                            class="w-full border-gray-300 border p-3 rounded-lg mb-3 focus:border-pink-500 focus:ring-1 focus:ring-pink-500"
                            placeholder="আপনার সহযোগিতা বা মন্তব্য এখানে লিখুন..."
                            rows="4"
                            required></textarea>

                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-pink-700 transition font-semibold">
                    রিপ্লাই জমা দিন
                </button>
            </form>
        @endif

        {{-- রিপ্লাই তালিকা --}}
        <div class="space-y-4">
            @forelse($post->replies as $reply)
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center text-xs text-gray-500 mb-2 border-b pb-2">
                        <strong class="text-sm text-gray-700">{{ $reply->user->name }}</strong>
                        <div class="flex items-center gap-3">
                            <span>{{ $reply->created_at->diffForHumans() }}</span>
                            
                            {{-- রিপ্লাই ডিলেট অপশন --}}
                            @if(Auth::check() && Auth::id() === $reply->user_id)
                                <form action="{{ route('forum.reply.destroy', $reply) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition"
                                            onclick="return confirm('আপনি কি নিশ্চিত? রিপ্লাইটি ডিলেট হয়ে যাবে।')">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <p class="text-gray-800 mt-2">{!! nl2br(e($reply->reply_text)) !!}</p>
                </div>
            @empty
                 <p class="text-gray-600 text-center py-4">এখনও কোনো রিপ্লাই জমা পড়েনি। আপনিই প্রথম রিপ্লাইটি দিন।</p>
            @endforelse
        </div>
    </div>
</div>

{{-- **3. রিপোর্ট মোডাল (Modal) - Tailwind Friendly** --}}
{{-- Note: This requires the layouts.app to include Bootstrap JS/CSS for modals --}}
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('forum.report.store', $post) }}" method="POST">
                @csrf
                <div class="modal-header bg-yellow-500 text-white">
                    <h5 class="modal-title" id="reportModalLabel">⚠️ এই পোস্টটি রিপোর্ট করার কারণ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>আপনি কেন এই পোস্টটি আপত্তিকর মনে করছেন? (ঐচ্ছিক)</p>
                    <div class="mb-3">
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="অপব্যবহার, হয়রানি, বা অন্য কোনো নিয়ম লঙ্ঘনের কারণ উল্লেখ করুন।"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">রিপোর্ট জমা দিন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection