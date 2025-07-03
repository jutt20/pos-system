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
            <p class="page-subtitle">Business insights and performance metrics</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('reports.export') }}" class="btn-primary">
                <i class="fas fa-download me-2"></i>
                Export Excel
            </a>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Customers</div>
                <div class="stat-value">{{ $totalCustomers }}</div>
                <div class="stat-change positive">+12% this month</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Monthly Revenue</div>
                <div class="stat-value green">${{ number_format($monthlyRevenue, 2) }}</div>
                <div class="stat-change positive">+8% from last month</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Activations</div>
                <div class="stat-value">{{ $totalActivations }}</div>
                <div class="stat-change positive">+15% this month</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Profit Margin</div>
                <div class="stat-value">{{ number_format($profitMargin, 1) }}%</div>
                <div class="stat-change positive">+2.3% improvement</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Revenue Trend</h2>
                    <div class="section-actions">
                        <select class="form-select" id="periodSelect">
                            <option value="7">Last 7 days</option>
                            <option value="30" selected>Last 30 days</option>
                            <option value="90">Last 90 days</option>
                            <option value="365">Last year</option>
                        </select>
                    </div>
                </div>
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="content-section">
                <h2 class="section-title">Top Performing Brands</h2>
                <div class="brand-performance">
                    @foreach($topBrands as $brand)
                    <div class="brand-item">
                        <div class="brand-info">
                            <span class="brand-name">{{ $brand->brand }}</span>
                            <span class="brand-count">{{ $brand->count }} activations</span>
                        </div>
                        <div class="brand-progress">
                            <div class="progress-bar" style="width: {{ ($brand->count / $topBrands->max('count')) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="content-section">
                <h2 class="section-title">Recent Transactions</h2>
                <div class="transaction-list">
                    @foreach($recentTransactions as $transaction)
                    <div class="transaction-item">
                        <div class="transaction-icon">
                            <i class="fas fa-{{ $transaction->type == 'invoice' ? 'file-invoice' : 'mobile-alt' }}"></i>
                        </div>
                        <div class="transaction-details">
                            <div class="transaction-title">{{ $transaction->description }}</div>
                            <div class="transaction-meta">{{ $transaction->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="transaction-amount">
                            ${{ number_format($transaction->amount, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="content-section">
                <h2 class="section-title">Customer Growth</h2>
                <canvas id="customerChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Financial Summary -->
    <div class="content-section">
        <h2 class="section-title">Monthly Financial Summary</h2>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Invoices</th>
                        <th>Total Billed</th>
                        <th>Revenue (Paid)</th>
                        <th>Collection Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyData as $data)
                    <tr>
                        <td>{{ date('F Y', mktime(0, 0, 0, $data->month, 1, $data->year)) }}</td>
                        <td>{{ $data->invoices }}</td>
                        <td>${{ number_format($data->total_billed, 2) }}</td>
                        <td>${{ number_format($data->revenue, 2) }}</td>
                        <td>{{ $data->total_billed > 0 ? number_format(($data->revenue / $data->total_billed) * 100, 1) : 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Customers -->
    <div class="content-section">
        <h2 class="section-title">Top Customers by Revenue</h2>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Total Revenue</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topCustomers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->company ?? '-' }}</td>
                        <td>${{ number_format($customer->invoices_sum_total_amount ?? 0, 2) }}</td>
                        <td class="{{ $customer->balance > 0 ? 'text-success' : 'text-danger' }}">
                            ${{ number_format($customer->balance, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Activations by Brand -->
    <div class="content-section">
        <h2 class="section-title">Activations by Brand</h2>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Total Activations</th>
                        <th>Total Profit</th>
                        <th>Average Profit per Activation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activationsByBrand as $brand)
                    <tr>
                        <td>{{ $brand->brand }}</td>
                        <td>{{ $brand->count }}</td>
                        <td class="text-success">${{ number_format($brand->total_profit, 2) }}</td>
                        <td>${{ number_format($brand->total_profit / $brand->count, 2) }}</td>
                    </tr>
                    @endforeach
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
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($revenueLabels) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($revenueData) !!},
            borderColor: '#3b82f6',
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
                grid: {
                    color: '#f3f4f6'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Customer Chart
const customerCtx = document.getElementById('customerChart').getContext('2d');
new Chart(customerCtx, {
    type: 'doughnut',
    data: {
        labels: ['New Customers', 'Returning Customers'],
        datasets: [{
            data: [{{ $newCustomers }}, {{ $returningCustomers }}],
            backgroundColor: ['#10b981', '#3b82f6'],
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
@endpush
