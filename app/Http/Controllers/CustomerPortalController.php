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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Find customer record for this user
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            // Create customer record if doesn't exist
            $customer = Customer::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? null,
                'balance' => 250.00,
                'prepaid_status' => 'prepaid',
            ]);
        }

        // Get customer's activations
        $activations = Activation::where('customer_id', $customer->id)
            ->latest()
            ->take(10)
            ->get();

        // Get customer's SIM orders
        $simOrders = SimOrder::where('customer_id', $customer->id)
            ->latest()
            ->take(10)
            ->get();

        // Get customer's invoices
        $invoices = Invoice::where('customer_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        // Calculate stats
        $stats = [
            'total_activations' => $activations->count(),
            'active_services' => $activations->where('status', 'active')->count(),
            'total_orders' => $simOrders->count(),
            'pending_orders' => $simOrders->where('status', 'pending')->count(),
            'account_balance' => $customer->balance,
            'total_spent' => $invoices->where('status', 'paid')->sum('total_amount'),
        ];

        return view('customer-portal.dashboard', compact(
            'customer', 
            'activations', 
            'simOrders', 
            'invoices', 
            'stats'
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
            ->paginate(15);

        return view('customer-portal.activations', compact('activations', 'customer'));
    }

    public function orders()
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            return redirect()->route('customer-portal.dashboard');
        }

        $simOrders = SimOrder::where('customer_id', $customer->id)
            ->paginate(15);

        return view('customer-portal.orders', compact('simOrders', 'customer'));
    }

    public function invoices()
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();
        
        if (!$customer) {
            return redirect()->route('customer-portal.dashboard');
        }

        $invoices = Invoice::where('customer_id', $customer->id)
            ->paginate(15);

        return view('customer-portal.invoices', compact('invoices', 'customer'));
    }
}
