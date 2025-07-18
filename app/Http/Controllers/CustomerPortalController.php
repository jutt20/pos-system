<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPortalController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get customer record
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            // Create customer record if doesn't exist
            $customer = Customer::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'address' => '',
                'created_by' => 1 // Admin user
            ]);
        }

        // Get customer statistics
        $totalInvoices = Invoice::where('customer_id', $customer->id)->count();
        $totalSpent = Invoice::where('customer_id', $customer->id)
            ->where('status', 'paid')
            ->sum('total_amount');
        $activeServices = Activation::where('customer_id', $customer->id)
            ->where('status', 'active')
            ->count();
        $pendingOrders = SimOrder::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->count();

        // Recent invoices
        $recentInvoices = Invoice::where('customer_id', $customer->id)
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        // Recent activations
        $recentActivations = Activation::where('customer_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('customer-portal.dashboard', compact(
            'customer',
            'totalInvoices',
            'totalSpent',
            'activeServices',
            'pendingOrders',
            'recentInvoices',
            'recentActivations'
        ));
    }

    public function activations()
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            return redirect()->route('customer-portal.dashboard');
        }

        $activations = Activation::where('customer_id', $customer->id)
            ->latest()
            ->paginate(20);

        return view('customer-portal.activations', compact('activations'));
    }

    public function orders()
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            return redirect()->route('customer-portal.dashboard');
        }

        $orders = SimOrder::where('customer_id', $customer->id)
            ->latest()
            ->paginate(20);

        return view('customer-portal.orders', compact('orders'));
    }

    public function invoices()
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            return redirect()->route('customer-portal.dashboard');
        }

        $invoices = Invoice::where('customer_id', $customer->id)
            ->with('items')
            ->latest()
            ->paginate(20);

        return view('customer-portal.invoices', compact('invoices'));
    }
}
