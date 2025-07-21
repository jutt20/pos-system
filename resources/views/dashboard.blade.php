@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Dashboard</h2>
        <div>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-calendar me-1"></i> {{ now()->format('F Y') }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                    <li><a class="dropdown-item" href="#">Last 3 Months</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Custom Range</a></li>
                </ul>
            </div>
            <button class="btn btn-outline-primary ms-2">
                <i class="fas fa-download me-1"></i> Export
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Revenue</h6>
                            <h3 class="mb-0">$24,580.00</h3>
                            <span class="badge bg-success-subtle text-success mt-2">
                                <i class="fas fa-arrow-up me-1"></i> 12.5%
                            </span>
                        </div>
                        <div class="icon-box bg-primary-subtle text-primary rounded-3 p-3">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Activations</h6>
                            <h3 class="mb-0">156</h3>
                            <span class="badge bg-success-subtle text-success mt-2">
                                <i class="fas fa-arrow-up me-1"></i> 8.2%
                            </span>
                        </div>
                        <div class="icon-box bg-success-subtle text-success rounded-3 p-3">
                            <i class="fas fa-mobile-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">SIM Orders</h6>
                            <h3 class="mb-0">42</h3>
                            <span class="badge bg-warning-subtle text-warning mt-2">
                                <i class="fas fa-arrow-down me-1"></i> 3.8%
                            </span>
                        </div>
                        <div class="icon-box bg-warning-subtle text-warning rounded-3 p-3">
                            <i class="fas fa-sim-card fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Profit</h6>
                            <h3 class="mb-0">$9,845.00</h3>
                            <span class="badge bg-success-subtle text-success mt-2">
                                <i class="fas fa-arrow-up me-1"></i> 15.3%
                            </span>
                        </div>
                        <div class="icon-box bg-info-subtle text-info rounded-3 p-3">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Revenue & Profit Trends</h5>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary active">Monthly</button>
                        <button type="button" class="btn btn-outline-secondary">Quarterly</button>
                        <button type="button" class="btn btn-outline-secondary">Yearly</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Activations by Brand</h5>
                </div>
                <div class="card-body">
                    <canvas id="brandChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Top Performers -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Activations</h5>
                    <a href="{{ route('activations.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Customer</th>
                                    <th>Plan</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>John Smith</div>
                                        </div>
                                    </td>
                                    <td>Nexitel Purple 5G</td>
                                    <td>{{ now()->subDays(2)->format('M d, Y') }}</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>Sarah Johnson</div>
                                        </div>
                                    </td>
                                    <td>Nexitel Blue Unlimited</td>
                                    <td>{{ now()->subDays(3)->format('M d, Y') }}</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>Robert Johnson</div>
                                        </div>
                                    </td>
                                    <td>Nexitel eSIM Premium</td>
                                    <td>{{ now()->subDays(5)->format('M d, Y') }}</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>Emily Davis</div>
                                        </div>
                                    </td>
                                    <td>Nexitel Purple Family</td>
                                    <td>{{ now()->subDays(7)->format('M d, Y') }}</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Top Performing Employees</h5>
                    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Activations</th>
                                    <th>Revenue</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>Mike Sales</div>
                                        </div>
                                    </td>
                                    <td>42</td>
                                    <td>$8,450</td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>David Retailer</div>
                                        </div>
                                    </td>
                                    <td>38</td>
                                    <td>$7,320</td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>John Manager</div>
                                        </div>
                                    </td>
                                    <td>29</td>
                                    <td>$5,890</td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>Sarah Billing</div>
                                        </div>
                                    </td>
                                    <td>18</td>
                                    <td>$2,920</td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [
                {
                    label: 'Revenue',
                    data: [12500, 15000, 17800, 16200, 18900, 21500, 24580],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Profit',
                    data: [4800, 5900, 6700, 6100, 7200, 8500, 9845],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
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

    // Brand Chart
    const brandCtx = document.getElementById('brandChart').getContext('2d');
    const brandChart = new Chart(brandCtx, {
        type: 'doughnut',
        data: {
            labels: ['Nexitel Purple', 'Nexitel Blue', 'eSIM Only'],
            datasets: [{
                data: [65, 25, 10],
                backgroundColor: [
                    '#8B5CF6',
                    '#3B82F6',
                    '#10B981'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            cutout: '65%'
        }
    });
</script>
@endsection

@section('styles')
<style>
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
    }
    
    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-primary-subtle {
        background-color: rgba(102, 126, 234, 0.15);
    }
    
    .bg-success-subtle {
        background-color: rgba(16, 185, 129, 0.15);
    }
    
    .bg-warning-subtle {
        background-color: rgba(245, 158, 11, 0.15);
    }
    
    .bg-info-subtle {
        background-color: rgba(59, 130, 246, 0.15);
    }
    
    .text-primary {
        color: #667eea !important;
    }
    
    .text-success {
        color: #10b981 !important;
    }
    
    .text-warning {
        color: #f59e0b !important;
    }
    
    .text-info {
        color: #3b82f6 !important;
    }
</style>
@endsection
