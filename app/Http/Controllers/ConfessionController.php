<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Confession;
use Carbon\Carbon;
use App\Models\ConfessionUpvote;
use App\Models\ConfessionReport;

class ConfessionController extends Controller
{
    public function index()
    {
        // Show only confessions created within the last 24 hours and not soft deleted
        $confessions = Confession::whereNull('deleted_at')
                                    ->where('created_at', '>=', Carbon::now()->subDay())
                                    ->latest()
                                    ->get();
        return view('confessions.index', compact('confessions'));
    }

    public function create()
    {
        return view('confessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'mood_id' => 'nullable|integer'
        ]);

        $userId = Auth::id();

        Confession::create([
            'content' => $request->content,
            'mood_id' => $request->mood_id,
            'user_id' => $userId,
            'upvotes' => 0,
            'reports' => 0,
            'created_at' => now()
        ]);

        if ($userId) {
            $user = Auth::user();
            $today = Carbon::today();

            if ($user->last_confession_at) {
                $lastConfessionDate = Carbon::parse($user->last_confession_at);

                if ($lastConfessionDate->diffInDays($today) === 1) {
                    $user->streak += 1;
                } elseif ($lastConfessionDate->diffInDays($today) > 1) {
                    $user->streak = 1;
                }
            } else {
                $user->streak = 1;
            }

            DB::table('users')->where('id', $userId)->update([
                'streak' => $user->streak,
                'last_confession_at' => now(),
            ]);
        }

        return redirect()->route('confessions.index')->with('success', 'Confession posted anonymously!');
    }

    public function show($id)
    {
        $confession = Confession::with(['comments.user', 'comments.replies.user', 'mood'])
                                ->findOrFail($id);

        return view('confessions.show', compact('confession'));
    }

    public function upvote($id)
    {
        $confession = Confession::findOrFail($id);
        $ip = request()->ip();
        $userId = Auth::check() ? Auth::id() : null;
    
        $alreadyUpvoted = ConfessionUpvote::where('confession_id', $id)
            ->where(function ($query) use ($ip, $userId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('ip_address', $ip);
                }
            })
            ->exists();
    
        if ($alreadyUpvoted) {
            return back()->with('message', 'You have already upvoted this confession.');
        }
    
        ConfessionUpvote::create([
            'confession_id' => $id,
            'ip_address' => $ip,
            'user_id' => $userId
        ]);
    
        $confession->increment('upvotes');
    
        return back()->with('message', 'Upvote recorded.');
    }

    public function report($id, Request $request)
    {
        $ip = $request->ip();
    
        $alreadyReported = ConfessionReport::where('confession_id', $id)
            ->where('ip_address', $ip)
            ->exists();
    
        if ($alreadyReported) {
            return redirect()->route('confessions.show', $id)
                             ->with('warning', 'You have already reported this confession.');
        }
    
        ConfessionReport::create([
            'confession_id' => $id,
            'ip_address' => $ip,
            'reason' => $request->input('reason', 'Inappropriate')
        ]);
    
        Confession::where('id', $id)->increment('reports');
    
        return redirect()->route('confessions.show', $id)
                         ->with('success', 'Report submitted successfully.');
    }


    public function trending()
    {
        $twentyFourHoursAgo = Carbon::now()->subHours(24);

        $confessions = Confession::withCount('comments')
            ->where('created_at', '>=', $twentyFourHoursAgo)
            ->whereNull('deleted_at')
            ->orderByRaw('(upvotes + comments_count) DESC')
            ->get();

        return view('confessions.trending', compact('confessions'));
    }
}
