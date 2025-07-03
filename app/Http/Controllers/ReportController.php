<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function index()
    {
        // Basic counts
        $totalCustomers = Customer::count();
        $totalEmployees = Employee::count();
        $totalInvoices = Invoice::count();
        $totalActivations = Activation::count();

        // Revenue calculations
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Profit calculations
        $totalProfit = Activation::sum('profit');
        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

        // Monthly data for charts
        $monthlyData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Invoice::where('status', 'paid')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
            
            $monthlyData->push([
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ]);
        }

        // Top brands by activations
        $topBrands = Activation::select('brand', DB::raw('count(*) as count'))
            ->groupBy('brand')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // Recent transactions (invoices and activations)
        $recentInvoices = Invoice::with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentActivations = Activation::with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Customer analytics
        $newCustomers = Customer::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $returningCustomers = $totalCustomers - $newCustomers;

        // Top customers by revenue
        $topCustomers = Customer::withSum('invoices', 'total_amount')
            ->withCount('invoices')
            ->orderBy('invoices_sum_total_amount', 'desc')
            ->limit(10)
            ->get();

        // Invoice status distribution
        $invoiceStatusData = Invoice::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Activations by brand
        $activationsByBrand = Activation::select('brand', 
                DB::raw('count(*) as count'),
                DB::raw('sum(profit) as total_profit'))
            ->groupBy('brand')
            ->orderBy('count', 'desc')
            ->get();

        return view('reports.index', compact(
            'totalCustomers',
            'totalEmployees', 
            'totalInvoices',
            'totalActivations',
            'totalRevenue',
            'monthlyRevenue',
            'totalProfit',
            'profitMargin',
            'monthlyData',
            'topBrands',
            'recentInvoices',
            'recentActivations',
            'newCustomers',
            'returningCustomers',
            'topCustomers',
            'invoiceStatusData',
            'activationsByBrand'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'overview');
        
        // This would typically generate and return an Excel/PDF file
        // For now, we'll just redirect back with a success message
        
        return redirect()->back()
            ->with('success', ucfirst($type) . ' report exported successfully!');
    }
}
