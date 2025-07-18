<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Activation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetailerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function dashboard()
    {
        $user = Auth::guard('employee')->user();

        // Get retailer's statistics
        $totalSales = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->sum('total_amount');

        $monthlyCommission = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount') * 0.05; // 5% commission

        $totalCustomers = Customer::where('assigned_employee_id', $user->id)->count();

        $activeActivations = Activation::where('employee_id', $user->id)
            ->where('status', 'active')
            ->count();

        // Recent transactions
        $recentTransactions = Invoice::where('employee_id', $user->id)
            ->with('customer')
            ->latest()
            ->take(10)
            ->get();

        // Monthly sales data for chart
        $monthlySales = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $salesData[] = $monthlySales[$i] ?? 0;
        }

        $todayCommission = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_amount') * 0.05;

        $totalCommission = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->sum('total_amount') * 0.05; // assuming 5% commission

        $todaySales = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->whereDate('created_at', now())
            ->sum('total_amount');

        $totalTransactions = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->count();

        $accountBalance = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->sum('total_amount');

        $stats = [
            'today_commission' => $todayCommission,
            'total_commission' => $totalCommission,
            'today_sales' => $todaySales,
            'total_transactions' => $totalTransactions,
            'account_balance' => $accountBalance
        ];


        return view('retailer.dashboard', compact(
            'totalSales',
            'monthlyCommission',
            'totalCustomers',
            'activeActivations',
            'recentTransactions',
            'salesData',
            'stats'
        ));
    }

    public function reports()
    {
        $user = Auth::guard('employee')->user();

        // Get monthly sales data
        $monthlySales = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->get();

        // Get top customers
        $topCustomers = Customer::where('assigned_employee_id', $user->id)
            ->withSum('invoices', 'total_amount')
            ->orderBy('invoices_sum_total_amount', 'desc')
            ->take(10)
            ->get();

        return view('retailer.reports', compact('monthlySales', 'topCustomers'));
    }

    public function transactions()
    {
        $user = Auth::guard('employee')->user();

        $transactions = Invoice::where('employee_id', $user->id)
            ->with('customer')
            ->latest()
            ->paginate(20);

        $totalTransactions = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->count();

        $totalVolume = Invoice::where('employee_id', $user->id)
            ->count();

        $totalRevenue = Invoice::where('employee_id', $user->id)
            ->sum('total_amount');

        $completedRevenue = Invoice::where('employee_id', $user->id)
            ->where('status', 'paid')
            ->sum('total_amount');

        $stats = [
            'total_transactions' => $totalTransactions,
            'total_volume' => $totalVolume,
            'total_revenue' => $totalRevenue,
            'completed_revenue' => $completedRevenue
        ];

        return view('retailer.transactions', compact('transactions', 'stats'));
    }
}
