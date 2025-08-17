<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Confession;
use App\Models\Comment;
use App\Models\ConfessionReport;
use App\Models\CommentReport;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Admin dashboard main page
        return view('admin.dashboard');
    }

    public function editUsers()
    {
        $users = User::withCount(['confessions', 'comments'])->get();
        return view('admin.editUsers', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        $user->is_admin = !$user->is_admin;
        $user->save();
        return redirect()->route('admin.editUsers')->with('success', 'User admin status updated successfully');
    }

    public function deleteUser(User $user)
    {
        // Delete a user
        $user->delete();
        return redirect()->route('admin.editUsers')->with('success', 'User deleted successfully');
    }

    public function editPosts()
    {
        $confessions = Confession::with('reports')
            ->withCount('reports as reports_count')
            ->has('reports')
            ->orderBy('reports_count', 'desc')
            ->get();
        return view('admin.editPosts', compact('confessions'));
    }

    public function deletePost(Confession $post)
    {
        // Delete the post
        $post->delete();
        return redirect()->route('admin.editPosts')->with('success', 'Post deleted successfully');
    }

    public function ignoreReport(Request $request, Confession $confession)
    {
        $report = ConfessionReport::find($request->report_id);
        if ($report) {
            $report->delete();
        }
        return redirect()->route('admin.editPosts')->with('success', 'Report ignored successfully');
    }

    public function editComments()
    {
        // Get all reported comments with their reports
        $comments = Comment::whereHas('reports')->with('reports')->get();
        return view('admin.editComments', compact('comments'));
    }

    public function deleteComment(Comment $comment)
    {
        // Delete the comment
        $comment->delete();
        return redirect()->route('admin.editComments')->with('success', 'Comment deleted successfully');
    }

    public function ignoreCommentReport(Comment $comment, Request $request)
    {
        $report = CommentReport::where('comment_id', $comment->id)
            ->where('id', $request->report)
            ->firstOrFail();
        
        $report->delete();
        
        return redirect()->route('admin.editComments')
            ->with('success', 'Report has been ignored successfully');
    }
}
