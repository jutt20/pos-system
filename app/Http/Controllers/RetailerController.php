<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Activation;
use App\Models\SimOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetailerController extends Controller
{
    public function dashboard()
    {
        // Sample retailer data - in real app, this would be based on authenticated retailer
        $stats = [
            'account_balance' => 500.00,
            'today_commission' => 0.00,
            'total_commission' => 0.00,
            'today_sales' => 247.50,
            'total_transactions' => 23,
            'completed_today' => 23,
        ];

        // Recent transactions
        $recentTransactions = [
            [
                'phone' => '+1-555-0123',
                'carrier' => 'Verizon',
                'amount' => 27.50,
                'fee' => 2.50,
                'status' => 'Completed',
                'date' => now()->format('M d, Y H:i A')
            ]
        ];

        return view('retailer.dashboard', compact('stats', 'recentTransactions'));
    }

    public function transactions()
    {
        $stats = [
            'total_transactions' => 1,
            'total_volume' => 27.50,
            'completed_revenue' => 27.50,
        ];

        $transactions = [
            [
                'phone' => '+1-555-0123',
                'carrier' => 'Verizon',
                'amount' => 27.50,
                'fee' => 2.50,
                'status' => 'Completed',
                'date' => 'Jul 18, 2025, 08:34 AM'
            ]
        ];

        return view('retailer.transactions', compact('stats', 'transactions'));
    }

    public function reports()
    {
        return view('retailer.reports');
    }
}
