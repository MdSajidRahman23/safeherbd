<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumReply;
use App\Models\ForumReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Show all posts
    public function index()
    {
        $posts = ForumPost::with('user')->latest()->paginate(10);
        return view('forum.index', compact('posts'));
    }

    // Show "Create Post" Page
    public function create()
    {
        return view('forum.create');
    }

    // Store New Post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        ForumPost::create([
            'title'   => $request->title,
            'body'    => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('forum.index')->with('success', 'Post created!');
    }

    // View single post with replies
    public function show($id)
    {
        $post = ForumPost::with(['replies.user', 'user'])->findOrFail($id);
        return view('forum.show', compact('post'));
    }

    // Store a reply on a post
    public function storeReply(Request $request, $id)
    {
        $request->validate([
            'reply_text' => 'required|string|max:2000'
        ]);

        ForumReply::create([
            'post_id'   => $id,
            'user_id'   => Auth::id(),
            'reply_text'=> $request->reply_text,
        ]);

        return back()->with('success', 'Reply added!');
    }

    // Report a post
    public function reportPost($id)
    {
        // Prevent duplicate reports by same user
        $existingReport = ForumReport::where('post_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReport) {
            return back()->with('message', 'You already reported this post.');
        }

        ForumReport::create([
            'post_id' => $id,
            'user_id' => Auth::id(),
            'reason'  => 'Flagged',
        ]);

        return back()->with('message', 'Post reported.');
    }

    // Delete Post (Only owner)
    public function destroy($id)
    {
        $post = ForumPost::findOrFail($id);

        // Authorization check
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You are not allowed to delete this post.');
        }

        $post->delete();
        return redirect()->route('forum.index')->with('success', 'Post deleted.');
    }
}