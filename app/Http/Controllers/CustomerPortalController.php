<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Activation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        
        $totalSpent = $customer->invoices()->where('status', 'paid')->sum('total_amount');
        $pendingInvoices = $customer->invoices()->where('status', '!=', 'paid')->count();
        $activeServices = $customer->activations()->where('status', 'active')->count();
        
        $recentInvoices = $customer->invoices()
            ->latest()
            ->take(5)
            ->get();
            
        $recentActivations = $customer->activations()
            ->latest()
            ->take(5)
            ->get();

        return view('customer-portal.dashboard', compact(
            'totalSpent',
            'pendingInvoices',
            'activeServices',
            'recentInvoices',
            'recentActivations'
        ));
    }

    public function invoices()
    {
        $customer = Auth::guard('customer')->user();
        $invoices = $customer->invoices()->latest()->paginate(10);
        
        return view('customer-portal.invoices', compact('invoices'));
    }

    public function activations()
    {
        $customer = Auth::guard('customer')->user();
        $activations = $customer->activations()->latest()->paginate(10);
        
        return view('customer-portal.activations', compact('activations'));
    }

    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer-portal.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $customer->update($request->only([
            'name', 'email', 'phone', 'address', 'city', 'state', 'zip_code'
        ]));

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
