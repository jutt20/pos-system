<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RetailerLoginController extends Controller
{
    public function create()
    {
        return view('auth.retailer-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::guard('employee')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::guard('employee')->user();
            
            // Check if user has retailer role
            if (!$user->hasRole('Retailer')) {
                Auth::guard('employee')->logout();
                throw ValidationException::withMessages([
                    'username' => 'You do not have retailer access.',
                ]);
            }

            return redirect()->intended(route('retailer.dashboard'));
        }

        throw ValidationException::withMessages([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('retailer.login');
    }
}
