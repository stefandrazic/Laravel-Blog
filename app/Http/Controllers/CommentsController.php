<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        Comment::create([
            "post_id" => $request->input("post_id"),
            "body" => $request->input("body"),
            "user_id" => auth()->user()->id
        ]);
        return redirect()->back()->with('status', 'Successfully created comment!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Comment::findOrFail($id)->update(['body' => $request->input('body')]);
        return redirect()->back()->with('status', 'Successfully edited comment!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comment::where('id', $id)->first()->delete();
        return redirect()->back()->with('status', 'Successfully deleted comment!');
    }
}
