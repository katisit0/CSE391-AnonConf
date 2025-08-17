<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mood;
use App\Models\Confession;
use Carbon\Carbon;

class MoodController extends Controller
{
    public function search(Request $request, $moodName)
    {
        try {
            $mood = Mood::where('name', $moodName)->firstOrFail();
            $twentyFourHoursAgo = Carbon::now()->subHours(24);

            $confessions = $mood->confessions()
                ->where('created_at', '>=', $twentyFourHoursAgo)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('moods.search', compact('confessions', 'mood'));
        } catch (\Exception $e) {
            return view('moods.search', [
                'message' => 'Mood not found or an error occurred.',
                'mood' => null
            ]);
        }
    }
}
