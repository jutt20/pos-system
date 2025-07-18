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
        
        // Get customer statistics
        $totalInvoices = $customer->invoices()->count();
        $paidInvoices = $customer->invoices()->where('status', 'paid')->count();
        $pendingInvoices = $customer->invoices()->where('status', 'draft')->count();
        $overdueInvoices = $customer->invoices()->where('status', 'overdue')->count();
        
        $totalSpent = $customer->invoices()->where('status', 'paid')->sum('total_amount');
        $currentBalance = $customer->balance;
        
        $activeServices = $customer->activations()->where('status', 'active')->count();
        
        // Recent invoices
        $recentInvoices = $customer->invoices()
            ->with('employee')
            ->latest()
            ->take(5)
            ->get();
            
        // Recent activations
        $recentActivations = $customer->activations()
            ->with('employee')
            ->latest()
            ->take(5)
            ->get();

        return view('customer-portal.dashboard', compact(
            'customer',
            'totalInvoices',
            'paidInvoices',
            'pendingInvoices',
            'overdueInvoices',
            'totalSpent',
            'currentBalance',
            'activeServices',
            'recentInvoices',
            'recentActivations'
        ));
    }

    public function invoices()
    {
        $customer = Auth::guard('customer')->user();
        $invoices = $customer->invoices()
            ->with('employee')
            ->latest()
            ->paginate(15);

        return view('customer-portal.invoices', compact('invoices'));
    }

    public function activations()
    {
        $customer = Auth::guard('customer')->user();
        $activations = $customer->activations()
            ->with('employee')
            ->latest()
            ->paginate(15);

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
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->only([
            'name', 'email', 'phone', 'company', 'address'
        ]));

        return back()->with('success', 'Profile updated successfully!');
    }
}
