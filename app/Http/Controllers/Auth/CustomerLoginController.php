<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerLoginController extends Controller
{
    /**
     * Display the customer login view.
     */
    public function create(): View
    {
        return view('auth.customer-login');
    }

    /**
     * Handle an incoming customer authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if user has customer role or permissions
        $user = Auth::user();
        if (!$user->hasRole('Customer') && !$user->can('access customer portal')) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'You do not have permission to access the customer portal.',
            ]);
        }

        return redirect()->intended(route('customer-portal.dashboard'));
    }

    /**
     * Destroy an authenticated customer session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
}
