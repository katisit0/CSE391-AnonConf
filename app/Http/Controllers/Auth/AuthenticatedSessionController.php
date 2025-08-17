<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form (for normal or admin users).
     */
    public function create(Request $request): View
    {
        $adminMode = $request->routeIs('admin.login');

        // Set or clear admin flag in session
        session(['is_admin_mode' => $adminMode]);

        return view('auth.login', compact('adminMode'));
    }

    /**
     * Process the login form submission.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        if (session('is_admin_mode')) {
            session()->forget('is_admin_mode');

            if (!Auth::user()->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'You are not an admin.']);
            }

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
