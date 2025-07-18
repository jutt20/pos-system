<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RetailerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.retailer-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('employee')->attempt($credentials, $request->filled('remember'))) {
            $user = Auth::guard('employee')->user();
            
            // Check if user has retailer role
            if ($user->hasRole('Retailer')) {
                $request->session()->regenerate();
                return redirect()->intended(route('retailer.dashboard'));
            } else {
                Auth::guard('employee')->logout();
                throw ValidationException::withMessages([
                    'username' => 'You do not have retailer access.',
                ]);
            }
        }

        throw ValidationException::withMessages([
            'username' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('retailer.login');
    }
}
