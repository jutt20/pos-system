@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="main-container">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-chart-bar me-2"></i>
                Reports & Analytics
            </h1>
            <p class="page-subtitle">Comprehensive business insights and performance metrics</p>
        </div>
        <div class="header-actions">
            <div class="dropdown">
                <button class="btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-2"></i>
                    Export Reports
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('reports.export', ['type' => 'overview']) }}">
                        <i class="fas fa-file-pdf me-2"></i>Overview Report
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', ['type' => 'customers']) }}">
                        <i class="fas fa-users me-2"></i>Customer Report
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', ['type' => 'invoices']) }}">
                        <i class="fas fa-file-invoice me-2"></i>Invoice Report
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', ['type' => 'activations']) }}">
                        <i class="fas fa-mobile-alt me-2"></i>Activation Report
                    </a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Customers</div>
                <div class="stat-value">{{ number_format($totalCustomers) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    +12% from last month
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
                    <i class="fas fa-arrow-up"></i>
                    +8% from last month
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Invoices</div>
                <div class="stat-value">{{ number_format($totalInvoices) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    +15% from last month
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Activations</div>
                <div class="stat-value">{{ number_format($totalActivations) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    +22% from last month
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">Revenue Trend</h3>
                    <div class="section-actions">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>Last 12 Months</option>
                            <option>Last 6 Months</option>
                            <option>Last 3 Months</option>
                        </select>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">Invoice Status</h3>
                </div>
                <div class="chart-container">
                    <canvas id="statusChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-6">
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">Recent Invoices</h3>
                    <a href="{{ route('invoices.index') }}" class="btn-sm btn-outline">View All</a>
                </div>
                <div class="activity-list">
                    @forelse($recentInvoices as $invoice)
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <div class="user-avatar">
                                {{ strtoupper(substr($invoice->customer->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">
                                Invoice #{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="activity-subtitle">
                                {{ $invoice->customer->name }} • ${{ number_format($invoice->total_amount, 2) }}
                            </div>
                        </div>
                        <div class="activity-meta">
                            <span class="status-badge status-{{ $invoice->status }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                            <small class="text-muted">{{ $invoice->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state-sm">
                        <i class="fas fa-file-invoice fa-2x text-muted mb-2"></i>
                        <p class="text-muted">No recent invoices</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">Recent Activations</h3>
                    <a href="{{ route('activations.index') }}" class="btn-sm btn-outline">View All</a>
                </div>
                <div class="activity-list">
                    @forelse($recentActivations as $activation)
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <div class="user-avatar">
                                {{ strtoupper(substr($activation->customer->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">
                                {{ $activation->phone_number }}
                            </div>
                            <div class="activity-subtitle">
                                {{ $activation->customer->name }} • {{ $activation->plan_name }}
                            </div>
                        </div>
                        <div class="activity-meta">
                            <span class="status-badge status-{{ $activation->status }}">
                                {{ ucfirst($activation->status) }}
                            </span>
                            <small class="text-muted">{{ $activation->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state-sm">
                        <i class="fas fa-mobile-alt fa-2x text-muted mb-2"></i>
                        <p class="text-muted">No recent activations</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Top Customers -->
    <div class="content-section mt-4">
        <div class="section-header">
            <h3 class="section-title">Top Customers by Revenue</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Customer</th>
                        <th>Total Revenue</th>
                        <th>Total Invoices</th>
                        <th>Last Activity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topCustomers as $index => $customer)
                    <tr>
                        <td>
                            <div class="rank-badge rank-{{ $index + 1 }}">
                                #{{ $index + 1 }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $customer->name }}</div>
                                    <small class="text-muted">{{ $customer->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold text-success">
                            ${{ number_format($customer->invoices_sum_total_amount ?? 0, 2) }}
                        </td>
                        <td>{{ $customer->invoices_count ?? 0 }}</td>
                        <td>{{ $customer->updated_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('customers.show', $customer) }}" class="btn-sm btn-outline">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No customer data available</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(collect($monthlyData)->pluck('month')) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode(collect($monthlyData)->pluck('revenue')) !!},
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
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

// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($invoiceStatusData->pluck('status')) !!},
        datasets: [{
            data: {!! json_encode($invoiceStatusData->pluck('count')) !!},
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',
                'rgba(251, 191, 36, 0.8)',
                'rgba(239, 68, 68, 0.8)',
                'rgba(156, 163, 175, 0.8)'
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
</script>

<style>
.rank-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-weight: bold;
    font-size: 0.875rem;
}

.rank-1 {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #92400e;
}

.rank-2 {
    background: linear-gradient(135deg, #c0c0c0, #e5e7eb);
    color: #374151;
}

.rank-3 {
    background: linear-gradient(135deg, #cd7f32, #d97706);
    color: white;
}

.rank-badge:not(.rank-1):not(.rank-2):not(.rank-3) {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    color: #6b7280;
}

.activity-list {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-avatar {
    margin-right: 12px;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: #111827;
    margin-bottom: 2px;
}

.activity-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
}

.activity-meta {
    text-align: right;
}

.empty-state-sm {
    text-align: center;
    padding: 40px 20px;
}

.chart-container {
    position: relative;
    height: 300px;
    padding: 20px 0;
}
</style>
@endpush
