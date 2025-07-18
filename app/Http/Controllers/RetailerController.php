<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RetailerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Get retailer's performance data
        $todayStart = now()->startOfDay();
        $monthStart = now()->startOfMonth();
        
        // Calculate commissions (assuming 2.5% commission rate)
        $todayRevenue = Invoice::whereDate('created_at', today())
            ->where('status', 'paid')
            ->sum('total_amount');
            
        $totalRevenue = Invoice::where('status', 'paid')
            ->sum('total_amount');
            
        $todayCommission = $todayRevenue * 0.025; // 2.5% commission
        $totalCommission = $totalRevenue * 0.025;

        $stats = [
            'account_balance' => 1250.75,
            'today_commission' => $todayCommission,
            'total_commission' => $totalCommission,
            'today_sales' => $todayRevenue,
            'total_transactions' => Invoice::count(),
            'completed_today' => Invoice::whereDate('created_at', today())->count(),
            'pending_activations' => Activation::where('status', 'pending')->count(),
            'monthly_target' => 5000.00,
            'monthly_achieved' => Invoice::whereMonth('created_at', now()->month)
                ->where('status', 'paid')
                ->sum('total_amount'),
        ];

        // Recent transactions
        $recentTransactions = Invoice::with('customer')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($invoice) {
                return [
                    'id' => $invoice->id,
                    'customer_name' => $invoice->customer->name ?? 'Unknown',
                    'phone' => $invoice->customer->phone ?? 'N/A',
                    'amount' => $invoice->total_amount,
                    'fee' => $invoice->total_amount * 0.025,
                    'status' => ucfirst($invoice->status),
                    'date' => $invoice->created_at->format('M d, Y H:i A'),
                    'invoice_number' => $invoice->invoice_number,
                ];
            });

        // Monthly performance data for chart
        $monthlyData = Invoice::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue, COUNT(*) as transactions')
            ->whereYear('created_at', now()->year)
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('retailer.dashboard', compact('stats', 'recentTransactions', 'monthlyData'));
    }

    public function transactions()
    {
        $transactions = Invoice::with('customer')
            ->latest()
            ->paginate(20);

        $stats = [
            'total_transactions' => Invoice::count(),
            'total_volume' => Invoice::where('status', 'paid')->sum('total_amount'),
            'completed_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'pending_transactions' => Invoice::where('status', 'pending')->count(),
        ];

        $transactionData = $transactions->map(function($invoice) {
            return [
                'id' => $invoice->id,
                'customer_name' => $invoice->customer->name ?? 'Unknown',
                'phone' => $invoice->customer->phone ?? 'N/A',
                'amount' => $invoice->total_amount,
                'fee' => $invoice->total_amount * 0.025,
                'status' => ucfirst($invoice->status),
                'date' => $invoice->created_at->format('M d, Y H:i A'),
                'invoice_number' => $invoice->invoice_number,
            ];
        });

        return view('retailer.transactions', compact('stats', 'transactionData', 'transactions'));
    }

    public function reports()
    {
        $user = Auth::user();
        
        // Generate comprehensive reports
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Invoice::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'paid')
                ->sum('total_amount');
                
            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue,
                'commission' => $revenue * 0.025,
                'transactions' => Invoice::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }

        // Top performing services
        $topServices = Activation::selectRaw('plan_name, COUNT(*) as count, SUM(cost) as revenue')
            ->groupBy('plan_name')
            ->orderByDesc('revenue')
            ->take(10)
            ->get();

        return view('retailer.reports', compact('monthlyStats', 'topServices'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('retailer.profile', compact('user'));
    }
}
