<?php

namespace App\Http\Controllers;

use App\Mail\CreatePostMail;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(3);
        return view('pages.posts', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:5|max:255',
            'body' => 'required|string|min:10|max:5000'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->user()->id
        ]);
        $post->tags()->attach($request->tags);
        $userEmail = Auth::user()->email;
        $mailData = $post->only('title', 'body', 'id');
        Mail::to($userEmail)->send(new CreatePostMail($mailData));
        return redirect('createpost')->with('status', 'Post successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::where('post_id', $id)->get();
        $likes = $post->likes()->where('type', 'like')->count();
        $dislikes = $post->likes()->where('type', 'dislike')->count();
        return view('pages.post', compact('post', 'comments', 'likes', 'dislikes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id)->update([
            'title' => $request->title,
            'body' => $request->body
        ]);
        return redirect()->back()->with('status', 'Post edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::findOrFail($id)->delete();
        return redirect('/posts')->with('status', 'Post deleted successfully!');
    }

    public function createPost()
    {
        $tags = Tag::all();
        return view('pages.auth.createpost', compact('tags'));
    }
}
