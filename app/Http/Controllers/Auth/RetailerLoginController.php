<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RetailerLoginController extends Controller
{
    /**
     * Display the retailer login view.
     */
    public function create(): View
    {
        return view('auth.retailer-login');
    }

    /**
     * Handle an incoming retailer authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if user has retailer role
        $user = Auth::user();
        if (!$user->hasRole('retailer')) {
            Auth::logout();
            return back()->withErrors([
                'username' => 'You do not have retailer access.',
            ]);
        }

        return redirect()->intended(route('retailer.dashboard'));
    }

    /**
     * Destroy an authenticated retailer session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/retailer/login');
    }
}
