@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-chart-bar"></i>
                Reports & Analytics
            </h1>
            <p class="page-subtitle">Comprehensive business insights and performance metrics</p>
        </div>
        <div class="header-actions">
            <div class="dropdown">
                <button class="btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download"></i>
                    Export Reports
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('reports.export', ['type' => 'overview']) }}">
                        <i class="fas fa-file-pdf"></i> Overview Report
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', ['type' => 'customers']) }}">
                        <i class="fas fa-file-excel"></i> Customer Report
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', ['type' => 'invoices']) }}">
                        <i class="fas fa-file-csv"></i> Invoice Report
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', ['type' => 'activations']) }}">
                        <i class="fas fa-file-alt"></i> Activation Report
                    </a></li>
                </ul>
            </div>
            <button class="btn-primary" onclick="refreshReports()">
                <i class="fas fa-sync-alt"></i>
                Refresh Data
            </button>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Customers</div>
                <div class="stat-value blue">{{ number_format($totalCustomers) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +{{ $newCustomers }} this month
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value green">${{ number_format($totalRevenue, 2) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> ${{ number_format($monthlyRevenue, 2) }} this month
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Activations</div>
                <div class="stat-value">{{ number_format($totalActivations) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +15% from last month
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Profit Margin</div>
                <div class="stat-value">{{ number_format($profitMargin, 1) }}%</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +2.3% improvement
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-chart-line"></i>
                Revenue Trends (Last 12 Months)
            </h2>
            <div class="section-actions">
                <select class="form-select" style="width: auto;">
                    <option>Last 12 Months</option>
                    <option>Last 6 Months</option>
                    <option>Last 3 Months</option>
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Customers & Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-star"></i>
                        Top Customers by Revenue
                    </h2>
                </div>
                
                @if($topCustomers->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Revenue</th>
                                <th>Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topCustomers->take(5) as $customer)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($customer->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $customer->name }}</div>
                                            <small class="text-muted">{{ $customer->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">
                                        ${{ number_format($customer->invoices_sum_total_amount ?? 0, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $customer->invoices_count ?? 0 }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-users fa-3x"></i>
                    <h5>No Customer Data</h5>
                    <p>Customer revenue data will appear here.</p>
                </div>
                @endif
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-clock"></i>
                        Recent Activity
                    </h2>
                </div>
                
                <div class="activity-timeline">
                    @if($recentInvoices->count() > 0)
                        @foreach($recentInvoices->take(5) as $invoice)
                        <div class="activity-item">
                            <div class="activity-icon bg-success">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">
                                    Invoice #{{ $invoice->id }} created
                                </div>
                                <div class="activity-description">
                                    @if($invoice->customer)
                                        {{ $invoice->customer->name }} - ${{ number_format($invoice->total_amount, 2) }}
                                    @else
                                        Amount: ${{ number_format($invoice->total_amount, 2) }}
                                    @endif
                                </div>
                                <div class="activity-time">
                                    {{ $invoice->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    
                    @if($recentActivations->count() > 0)
                        @foreach($recentActivations->take(3) as $activation)
                        <div class="activity-item">
                            <div class="activity-icon bg-info">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">
                                    New activation completed
                                </div>
                                <div class="activity-description">
                                    @if($activation->customer)
                                        {{ $activation->customer->name }} - {{ $activation->brand }}
                                    @else
                                        Brand: {{ $activation->brand }}
                                    @endif
                                </div>
                                <div class="activity-time">
                                    {{ $activation->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Brand Performance -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-mobile-alt"></i>
                Activations by Brand
            </h2>
        </div>
        
        @if($activationsByBrand->count() > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Total Activations</th>
                        <th>Total Profit</th>
                        <th>Avg. Profit per Activation</th>
                        <th>Performance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activationsByBrand as $brand)
                    <tr>
                        <td>
                            <span class="badge" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">
                                {{ $brand->brand }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold">{{ number_format($brand->count) }}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-success">${{ number_format($brand->total_profit, 2) }}</span>
                        </td>
                        <td>
                            ${{ number_format($brand->count > 0 ? $brand->total_profit / $brand->count : 0, 2) }}
                        </td>
                        <td>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ $activationsByBrand->max('count') > 0 ? ($brand->count / $activationsByBrand->max('count')) * 100 : 0 }}%">
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-mobile-alt fa-3x"></i>
            <h5>No Activation Data</h5>
            <p>Brand performance data will appear here once activations are recorded.</p>
        </div>
        @endif
    </div>

    <!-- Invoice Status Distribution -->
    <div class="row">
        <div class="col-md-6">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-file-invoice"></i>
                        Invoice Status Distribution
                    </h2>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <canvas id="invoiceStatusChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-chart-pie"></i>
                        Quick Stats
                    </h2>
                </div>
                
                <div class="quick-stats">
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-primary">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="quick-stat-content">
                            <div class="quick-stat-value">{{ number_format($totalInvoices) }}</div>
                            <div class="quick-stat-label">Total Invoices</div>
                        </div>
                    </div>
                    
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="quick-stat-content">
                            <div class="quick-stat-value">{{ number_format($totalEmployees) }}</div>
                            <div class="quick-stat-label">Total Employees</div>
                        </div>
                    </div>
                    
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-info">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="quick-stat-content">
                            <div class="quick-stat-value">${{ number_format($averageInvoiceAmount ?? 0, 0) }}</div>
                            <div class="quick-stat-label">Avg Invoice Amount</div>
                        </div>
                    </div>
                    
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="quick-stat-content">
                            <div class="quick-stat-value">{{ number_format($averageActivationTime ?? 0, 1) }}</div>
                            <div class="quick-stat-label">Avg Activation Days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyData->pluck('month')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyData->pluck('revenue')) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Invoice Status Chart
    const statusCtx = document.getElementById('invoiceStatusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($invoiceStatusData->pluck('status')) !!},
            datasets: [{
                data: {!! json_encode($invoiceStatusData->pluck('count')) !!},
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(59, 130, 246, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    function refreshReports() {
        location.reload();
    }
</script>

<style>
    .activity-timeline {
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }

    .activity-description {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .activity-time {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .quick-stats {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .quick-stat-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 12px;
        transition: all 0.2s;
    }

    .quick-stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .quick-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .quick-stat-content {
        flex: 1;
    }

    .quick-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .quick-stat-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 500;
    }
</style>
@endpush
@endsection
