<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Confession;
use Carbon\Carbon;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
    
        $confessions = Confession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Map recent status to confessions
        $confessions->each(function ($confession) {
            $confession->is_recent = $confession->created_at->gt(Carbon::now()->subDay());
        });
    
        if ($confessions->isNotEmpty()) {
            $streak = 1;
            $lastDate = Carbon::parse($confessions->first()->created_at)->startOfDay(); // startOfDay to ignore time
            
            if ($lastDate->diffInHours(Carbon::now()) > 24) {
                $streak = 0;
            } else {
                // Loop through confessions to count consecutive days
                for ($i = 1; $i < $confessions->count(); $i++) {
                    $currentDate = Carbon::parse($confessions[$i]->created_at)->startOfDay(); // Current confession date
                    $expectedDate = $lastDate->copy()->subDay(); // Expected date for the streak
                    
                    if ($currentDate->equalTo($expectedDate)) { // Check if the current date is the expected date
                        // If the dates match, increment the streak
                        $streak++;
                        $lastDate = $currentDate; // Update lastDate to the current date
                    } else {
                        break;
                    }
                }
            }
            
            $user->streak = $streak;
            $user->save();
        }
    
        return view('profile.edit', [
            'user' => $user,
            'confessions' => $confessions
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
