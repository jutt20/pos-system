<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view reports');
    }

    public function index()
    {
        // Basic counts
        $totalCustomers = Customer::count();
        $totalInvoices = Invoice::count();
        $totalActivations = Activation::count();
        $totalOrders = SimOrder::count();
        $totalEmployees = Employee::count();

        // Revenue calculations
        $totalRevenue = Invoice::sum('total_amount');
        $monthlyRevenue = Invoice::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        $yearlyRevenue = Invoice::whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Recent data
        $recentInvoices = Invoice::with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentActivations = Activation::with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Monthly data for charts
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'revenue' => Invoice::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('total_amount'),
                'customers' => Customer::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
                'activations' => Activation::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
            ];
        }

        // Top customers by revenue
        $topCustomers = Customer::withSum('invoices', 'total_amount')
            ->orderBy('invoices_sum_total_amount', 'desc')
            ->limit(10)
            ->get();

        // Status distributions
        $invoiceStatusData = Invoice::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $activationStatusData = Activation::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Performance metrics
        $averageInvoiceAmount = Invoice::avg('total_amount');
        $averageActivationTime = Activation::where('status', 'active')
            ->avg(DB::raw('DATEDIFF(updated_at, created_at)'));

        return view('reports.index', compact(
            'totalCustomers',
            'totalInvoices', 
            'totalActivations',
            'totalOrders',
            'totalEmployees',
            'totalRevenue',
            'monthlyRevenue',
            'yearlyRevenue',
            'recentInvoices',
            'recentActivations',
            'monthlyData',
            'topCustomers',
            'invoiceStatusData',
            'activationStatusData',
            'averageInvoiceAmount',
            'averageActivationTime'
        ));
    }

    public function overview()
    {
        $data = $this->getOverviewData();
        return view('reports.overview', $data);
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'overview');
        
        switch ($type) {
            case 'customers':
                return $this->exportCustomers();
            case 'invoices':
                return $this->exportInvoices();
            case 'activations':
                return $this->exportActivations();
            default:
                return $this->exportOverview();
        }
    }

    private function getOverviewData()
    {
        return [
            'totalCustomers' => Customer::count(),
            'totalRevenue' => Invoice::sum('total_amount'),
            'totalActivations' => Activation::count(),
            'monthlyRevenue' => Invoice::whereMonth('created_at', now()->month)->sum('total_amount'),
            'recentInvoices' => Invoice::with('customer')->latest()->limit(10)->get(),
            'topCustomers' => Customer::withSum('invoices', 'total_amount')
                ->orderBy('invoices_sum_total_amount', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    private function exportCustomers()
    {
        // Implementation for customer export
        return response()->json(['message' => 'Customer export functionality']);
    }

    private function exportInvoices()
    {
        // Implementation for invoice export
        return response()->json(['message' => 'Invoice export functionality']);
    }

    private function exportActivations()
    {
        // Implementation for activation export
        return response()->json(['message' => 'Activation export functionality']);
    }

    private function exportOverview()
    {
        // Implementation for overview export
        return response()->json(['message' => 'Overview export functionality']);
    }
}
