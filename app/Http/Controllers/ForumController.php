<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumReply;
use App\Models\ForumReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // অথরাইজেশন চেকের জন্য

class ForumController extends Controller
{
    /**
     * Women-Only Access এবং Authentication নিশ্চিত করতে মিডলওয়্যার
     */
    public function __construct()
    {
        // নিশ্চিত করে যে ইউজার লগইন করা এবং is.female মিডলওয়্যার দ্বারা অনুমোদিত
        $this->middleware(['auth', 'is.female']);
    }

    // 1. Forum Home Page → List of Posts
    public function index()
    {
        // Paginate সহ পোস্টের তালিকা
        $posts = ForumPost::with('user')->latest()->paginate(10);
        return view('forum.index', compact('posts'));
    }

    // 2. Post Create (ফর্ম প্রদর্শন)
    public function create()
    {
        return view('forum.create');
    }

    // 3. Store New Post (Content Filtering Logic সহ)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        // **বেসিক কন্টেন্ট ফিল্টারিং লজিক (Harassment Detection):**
        $forbiddenWords = ['harass_word_1', 'harass_word_2', 'bad_word']; // আপনার তালিকা
        $content = strtolower($request->title . ' ' . $request->body);

        foreach ($forbiddenWords as $word) {
            if (str_contains($content, $word)) {
                return back()->withInput()->withErrors(['body' => 'আপনার পোস্টে আপত্তিকর শব্দ রয়েছে। অনুগ্রহ করে এটি সংশোধন করুন।']);
            }
        }
        // **ফিল্টারিং লজিক শেষ**
        
        ForumPost::create([
            'title'   => $request->title,
            'body'    => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('forum.index')->with('success', 'Post created successfully!');
    }

    // 4. Post View (Model Binding ব্যবহার করা হলো)
    public function show(ForumPost $post)
    {
        // রিপ্লাই এবং তাদের ইউজারদের একসাথে লোড করা
        $post->load('replies.user', 'user');
        return view('forum.show', compact('post'));
    }

    // 5. Post Edit (ফর্ম প্রদর্শন)
    public function edit(ForumPost $post)
    {
        // Authorization check: শুধুমাত্র পোস্টের মালিক এডিট করতে পারবে
        if (Auth::id() !== $post->user_id) {
            abort(403, 'You are not allowed to edit this post.');
        }
        return view('forum.edit', compact('post'));
    }

    // 6. Post Update 
    public function update(Request $request, ForumPost $post)
    {
        // Authorization check
        if (Auth::id() !== $post->user_id) {
            abort(403, 'You are not allowed to update this post.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        $post->update($request->only(['title', 'body']));

        return redirect()->route('forum.show', $post)->with('success', 'Post updated successfully.');
    }

    // 7. Post Delete (CRUD)
    public function destroy(ForumPost $post) // Model Binding ব্যবহার করা হলো
    {
        // Authorization check
        if (Auth::id() !== $post->user_id) {
            abort(403, 'You are not allowed to delete this post.');
        }

        $post->delete();
        return redirect()->route('forum.index')->with('success', 'Post deleted successfully.');
    }

    // 8. Forum Reply System → Comment with Timestamp
    public function storeReply(Request $request, ForumPost $post) // Model Binding ব্যবহার করা হলো
    {
        $request->validate([
            'reply_text' => 'required|string|max:2000'
        ]);

        ForumReply::create([
            'post_id'   => $post->id,
            'user_id'   => Auth::id(),
            'reply_text'=> $request->reply_text,
        ]);

        return back()->with('success', 'Reply added successfully!');
    }
    
    // 9. Reply Delete (নতুন যোগ করা হলো)
    public function destroyReply(ForumReply $reply)
    {
        // Authorization check: শুধুমাত্র রিপ্লাই এর মালিক ডিলেট করতে পারবে
        if (Auth::id() !== $reply->user_id) {
            abort(403, 'You are not allowed to delete this reply.');
        }

        $reply->delete();
        return back()->with('success', 'Reply deleted successfully.');
    }

    // 10. Report Option → If any post is inappropriate (Request থেকে কারণ নেওয়ার ব্যবস্থা করা হলো)
    public function reportPost(Request $request, ForumPost $post) // Model Binding ব্যবহার করা হলো
    {
        $request->validate([
            'reason' => 'nullable|string|max:500' // শো (show) ব্লেড টেমপ্লেটে এই ফিল্ডটি দরকার
        ]);
        
        // Prevent duplicate reports by same user
        $existingReport = ForumReport::where('post_id', $post->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReport) {
            return back()->with('error', 'You already reported this post.');
        }

        ForumReport::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            // Request থেকে কারণ নেওয়া হচ্ছে
            'reason'  => $request->reason ?? 'No specific reason provided.', 
        ]);

        return back()->with('success', 'Post reported successfully! The moderation team will review it.');
    }
}