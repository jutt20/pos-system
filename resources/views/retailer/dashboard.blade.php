@extends('layouts.retailer')

@section('title', 'Retailer Dashboard')
@section('page-title', 'Retailer Portal')
@section('page-subtitle', 'Welcome back, retailer1')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Today's Commission</div>
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="stat-value success">${{ number_format($stats['today_commission'], 2) }}</div>
        <div class="stat-subtitle">0 transactions today</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Total Commission</div>
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="stat-value info">${{ number_format($stats['total_commission'], 2) }}</div>
        <div class="stat-subtitle">0 total earnings</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Account Balance</div>
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
        <div class="stat-value success">${{ number_format($stats['account_balance'], 2) }}</div>
        <div class="stat-subtitle">Available for transactions</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Today's Sales</div>
            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
        </div>
        <div class="stat-value info">${{ number_format($stats['today_sales'], 2) }}</div>
        <div class="stat-subtitle">+12% from yesterday</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Transactions</div>
            <div class="stat-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_transactions'] }}</div>
        <div class="stat-subtitle">Completed today</div>
    </div>
</div>

<!-- Services Grid -->
<div class="services-grid">
    <div class="service-card">
        <div class="service-icon purple">
            <i class="fas fa-mobile-alt"></i>
        </div>
        <div class="service-title">Nexitel Services</div>
        <div class="service-description">Complete wireless service management</div>
        <div class="service-status available">6 Services Available</div>
    </div>
    
    <div class="service-card">
        <div class="service-icon orange">
            <i class="fas fa-phone"></i>
        </div>
        <div class="service-title">VoIP Services</div>
        <div class="service-description">Business phone systems</div>
        <div class="service-status orders">Activation & Bulk Orders</div>
    </div>
    
    <div class="service-card">
        <div class="service-icon green">
            <i class="fas fa-globe"></i>
        </div>
        <div class="service-title">Global Recharge</div>
        <div class="service-description">International mobile phone top-up</div>
        <div class="service-status available">2 Services Available</div>
    </div>
</div>

<!-- Recent Activity -->
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-clock"></i>
            Recent Activity
        </h2>
        <div class="section-actions">
            <a href="{{ route('retailer.transactions') }}" class="btn-outline">View All</a>
        </div>
    </div>
    
    <p class="text-muted mb-4">Your latest transactions and activities</p>
    
    @if(count($recentTransactions) > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Phone Number</th>
                        <th>Carrier</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $transaction)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-dollar-sign text-success me-2"></i>
                                <strong>{{ $transaction['phone'] }}</strong>
                            </div>
                        </td>
                        <td>{{ $transaction['carrier'] }}</td>
                        <td><strong>${{ number_format($transaction['amount'], 2) }}</strong></td>
                        <td>Fee: ${{ number_format($transaction['fee'], 2) }}</td>
                        <td>
                            <span class="status-badge status-completed">
                                <i class="fas fa-check-circle me-1"></i>
                                {{ $transaction['status'] }}
                            </span>
                        </td>
                        <td>{{ $transaction['date'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-history fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No recent activity</h5>
            <p class="text-muted">Your recent transactions will appear here</p>
        </div>
    @endif
</div>
@endsection
