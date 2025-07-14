<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'total_activations' => Activation::count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'total_cost' => Activation::sum('cost'),
            'total_profit' => Activation::sum('profit'),
            'sims_purchased' => SimOrder::sum('quantity'),
            'pending_invoices' => Invoice::where('status', 'sent')->count(),
        ];

        // Monthly revenue chart data
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->selectRaw('MONTH(invoice_date) as month, SUM(total_amount) as revenue')
            ->whereYear('invoice_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Activations by brand
        $activationsByBrand = Activation::selectRaw('brand, COUNT(*) as count')
            ->groupBy('brand')
            ->get();

        // Recent activities
        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $recentActivations = Activation::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'monthlyRevenue',
            'activationsByBrand',
            'recentInvoices',
            'recentActivations'
        ));
    }
}
