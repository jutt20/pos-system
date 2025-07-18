@extends('layouts.retailer')

@section('title', 'Transaction History')
@section('page-title', 'Transaction History')
@section('page-subtitle', 'View and manage your transaction records')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn-outline">
        <i class="fas fa-arrow-left me-2"></i>
        Back to Dashboard
    </a>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Total Transactions</div>
            <div class="stat-icon">
                <i class="fas fa-list"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_transactions'] }}</div>
        <div class="stat-subtitle">1 completed</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Total Volume</div>
            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
        </div>
        <div class="stat-value info">${{ number_format($stats['total_volume'], 2) }}</div>
        <div class="stat-subtitle">All transactions</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Completed Revenue</div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-value success">${{ number_format($stats['completed_revenue'], 2) }}</div>
        <div class="stat-subtitle">Successfully processed</div>
    </div>
</div>

<!-- Filters -->
<div class="filters-section">
    <h3 class="filters-title">
        <i class="fas fa-filter"></i>
        Filters
    </h3>
    <div class="filters-grid">
        <div class="filter-group">
            <label class="filter-label">Search</label>
            <input type="text" class="form-control" placeholder="Search phone, carrier, or country...">
        </div>
        <div class="filter-group">
            <label class="filter-label">Status</label>
            <select class="form-select">
                <option>All Statuses</option>
                <option>Completed</option>
                <option>Pending</option>
                <option>Failed</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label">Service</label>
            <select class="form-select">
                <option>All Services</option>
                <option>Mobile Recharge</option>
                <option>VoIP Services</option>
                <option>Global Recharge</option>
            </select>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Recent Transactions ({{ count($transactions) }})</h2>
        <div class="section-actions">
            <button class="btn-primary">
                <i class="fas fa-download me-2"></i>
                Export
            </button>
        </div>
    </div>
    
    @if(count($transactions) > 0)
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
                    @foreach($transactions as $transaction)
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
            <h5 class="text-muted">No transactions found</h5>
            <p class="text-muted">Your transaction history will appear here</p>
        </div>
    @endif
</div>
@endsection
