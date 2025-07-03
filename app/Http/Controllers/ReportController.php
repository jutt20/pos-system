<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

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

        return view('reports.index', compact(
            'stats',
            'monthlyData',
            'topCustomers',
            'activationsByBrand'
        ));
    }

    public function export()
    {
        return Excel::download(new ReportsExport, 'nexitel-reports-' . date('Y-m-d') . '.xlsx');
    }
}
