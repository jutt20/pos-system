<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use App\Models\OnlineSimOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
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
        $totalOrders = SimOrder::count() + OnlineSimOrder::count();

        // Revenue calculations
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Monthly revenue data for chart (last 6 months)
        $monthlyRevenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Invoice::where('status', 'paid')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
            $monthlyRevenueData[] = $revenue;
        }

        // Recent activities
        $recentActivities = [];
        
        // Recent customers
        $recentCustomers = Customer::latest()->take(3)->get();
        foreach ($recentCustomers as $customer) {
            $recentActivities[] = [
                'type' => 'customer',
                'icon' => 'fa-user-plus',
                'title' => 'New customer: ' . $customer->name,
                'time' => $customer->created_at->diffForHumans()
            ];
        }

        // Recent invoices
        $recentInvoices = Invoice::latest()->take(3)->get();
        foreach ($recentInvoices as $invoice) {
            $recentActivities[] = [
                'type' => 'invoice',
                'icon' => 'fa-file-invoice-dollar',
                'title' => 'Invoice #' . $invoice->invoice_number . ' created',
                'time' => $invoice->created_at->diffForHumans()
            ];
        }

        // Recent activations
        $recentActivationsData = Activation::latest()->take(2)->get();
        foreach ($recentActivationsData as $activation) {
            $recentActivities[] = [
                'type' => 'activation',
                'icon' => 'fa-sim-card',
                'title' => 'SIM activated: ' . $activation->phone_number,
                'time' => $activation->created_at->diffForHumans()
            ];
        }

        // Sort activities by time
        usort($recentActivities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        $recentActivities = array_slice($recentActivities, 0, 8);

        return view('dashboard', compact(
            'totalCustomers',
            'totalEmployees',
            'totalInvoices',
            'totalActivations',
            'totalOrders',
            'totalRevenue',
            'monthlyRevenue',
            'monthlyRevenueData',
            'recentActivities'
        ));
    }
}
