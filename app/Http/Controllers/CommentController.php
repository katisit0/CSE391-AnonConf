<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\CommentReport;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'confession_id' => 'required|exists:confessions,id',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to comment.');
        }

        Comment::create([
            'confession_id' => $request->confession_id,
            'user_id' => auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back();
    }




public function report(Request $request, Comment $comment)
    {
        $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        CommentReport::create([
            'comment_id' => $comment->id,
            'user_id' => Auth::id(),
            'reason' => $request->input('reason'),
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Comment reported successfully.');
    }


}
