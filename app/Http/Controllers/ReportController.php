<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'total_activations' => Activation::count(),
            'total_profit' => Activation::sum('profit'),
            'pending_invoices' => Invoice::where('status', 'sent')->count(),
            'total_orders' => SimOrder::count(),
        ];

        // Additional stats for enhanced reports
        $totalCustomers = Customer::count();
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');
        $totalActivations = Activation::count();
        $profitMargin = $stats['total_revenue'] > 0 ? 
            ($stats['total_profit'] / $stats['total_revenue']) * 100 : 0;

        // Monthly financial summary
        $monthlyData = Invoice::selectRaw('
            MONTH(billing_date) as month,
            YEAR(billing_date) as year,
            SUM(CASE WHEN status = "paid" THEN total_amount ELSE 0 END) as revenue,
            COUNT(*) as invoices,
            SUM(total_amount) as total_billed
        ')
        ->whereYear('billing_date', date('Y'))
        ->groupBy('year', 'month')
        ->orderBy('month')
        ->get();

        // Top customers by revenue
        $topCustomers = Customer::withSum(['invoices' => function($query) {
            $query->where('status', 'paid');
        }], 'total_amount')
        ->orderBy('invoices_sum_total_amount', 'desc')
        ->take(10)
        ->get();

        // Activations by brand
        $activationsByBrand = Activation::selectRaw('brand, COUNT(*) as count, SUM(profit) as total_profit')
            ->groupBy('brand')
            ->orderBy('count', 'desc')
            ->get();

        // Top performing brands
        $topBrands = Activation::selectRaw('brand, COUNT(*) as count')
            ->groupBy('brand')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // Revenue chart data
        $revenueLabels = [];
        $revenueData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenueLabels[] = $date->format('M j');
            $revenueData[] = Invoice::where('status', 'paid')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
        }

        // Customer growth data
        $newCustomers = Customer::whereMonth('created_at', Carbon::now()->month)->count();
        $returningCustomers = $totalCustomers - $newCustomers;

        // Recent transactions
        $recentTransactions = collect();
        
        // Add recent invoices
        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($invoice) {
                return (object)[
                    'type' => 'invoice',
                    'description' => 'Invoice #' . $invoice->invoice_number . ' - ' . $invoice->customer->name,
                    'amount' => $invoice->total_amount,
                    'created_at' => $invoice->created_at
                ];
            });

        // Add recent activations
        $recentActivations = Activation::with('customer')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($activation) {
                return (object)[
                    'type' => 'activation',
                    'description' => $activation->brand . ' activation - ' . $activation->customer->name,
                    'amount' => $activation->profit,
                    'created_at' => $activation->created_at
                ];
            });

        $recentTransactions = $recentInvoices->concat($recentActivations)
            ->sortByDesc('created_at')
            ->take(10);

        return view('reports.index', compact(
            'stats',
            'monthlyData',
            'topCustomers',
            'activationsByBrand',
            'totalCustomers',
            'monthlyRevenue',
            'totalActivations',
            'profitMargin',
            'topBrands',
            'revenueLabels',
            'revenueData',
            'newCustomers',
            'returningCustomers',
            'recentTransactions'
        ));
    }

    public function export()
    {
        return Excel::download(new ReportsExport, 'nexitel-reports-' . date('Y-m-d') . '.xlsx');
    }
}
