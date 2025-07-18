@extends('layouts.app')

@section('title', 'Admin Portal Dashboard')

@section('content')
<div class="main-container">
    <!-- Welcome Header -->
    <div class="welcome-section">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1 class="welcome-title">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="welcome-subtitle">Here's what's happening with your business today</p>
            </div>
            <div class="welcome-actions">
                <a href="{{ route('customers.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Add Customer
                </a>
                <a href="{{ route('invoices.create') }}" class="btn-outline">
                    <i class="fas fa-file-invoice"></i> New Invoice
                </a>
            </div>
        </div>
        <div class="welcome-stats">
            <div class="stat-item">
                <div class="stat-number">${{ number_format($stats['total_revenue'], 0) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['total_customers'] }}</div>
                <div class="stat-label">Customers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['total_activations'] }}</div>
                <div class="stat-label">Activations</div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card revenue">
            <div class="stat-card-header">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12%</span>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-value">${{ number_format($stats['total_revenue'], 2) }}</div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-description">Revenue from all paid invoices</div>
            </div>
            <div class="stat-action">
                <a href="{{ route('reports.index') }}" class="btn-link">View Reports</a>
            </div>
        </div>

        <div class="stat-card customers">
            <div class="stat-card-header">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8%</span>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total_customers'] }}</div>
                <div class="stat-label">Total Customers</div>
                <div class="stat-description">Active customer accounts</div>
            </div>
            <div class="stat-action">
                <a href="{{ route('customers.index') }}" class="btn-link">View All</a>
            </div>
        </div>

        <div class="stat-card activations">
            <div class="stat-card-header">
                <div class="stat-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15%</span>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total_activations'] }}</div>
                <div class="stat-label">SIM Activations</div>
                <div class="stat-description">Total activated SIM cards</div>
            </div>
            <div class="stat-action">
                <a href="{{ route('activations.index') }}" class="btn-link">View All</a>
            </div>
        </div>

        <div class="stat-card invoices">
            <div class="stat-card-header">
                <div class="stat-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="stat-trend neutral">
                    <i class="fas fa-minus"></i>
                    <span>{{ $stats['pending_invoices'] }}</span>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['pending_invoices'] }}</div>
                <div class="stat-label">Pending Invoices</div>
                <div class="stat-description">Invoices awaiting payment</div>
            </div>
            <div class="stat-action">
                <a href="{{ route('invoices.index') }}" class="btn-link">View All</a>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="services-section">
        <h2 class="section-title">
            <i class="fas fa-rocket"></i>
            Quick Actions
        </h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon customers">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">Add Customer</div>
                    <div class="service-description">Create a new customer account</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('customers.create') }}" class="btn-service">Create</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon invoices">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">Generate Invoice</div>
                    <div class="service-description">Create and send invoices</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('invoices.create') }}" class="btn-service">Create</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon activations">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">SIM Activation</div>
                    <div class="service-description">Activate new SIM cards</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('activations.create') }}" class="btn-service">Activate</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">SIM Orders</div>
                    <div class="service-description">Manage SIM card orders</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('sim-orders.create') }}" class="btn-service">Order</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon reports">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">Reports</div>
                    <div class="service-description">View business analytics</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('reports.index') }}" class="btn-service">View</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon stock">
                    <i class="fas fa-sim-card"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">SIM Stock</div>
                    <div class="service-description">Manage SIM inventory</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('sim-stocks.index') }}" class="btn-service">Manage</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-8">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-clock"></i>
                        Recent Activity
                    </h2>
                    <div class="section-actions">
                        <a href="{{ route('invoices.index') }}" class="btn-outline-sm">View All</a>
                    </div>
                </div>
                
                <div class="activity-list">
                    @foreach($recentInvoices as $invoice)
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <div class="avatar-circle {{ $invoice->status == 'paid' ? 'success' : 'warning' }}">
                                <i class="fas fa-{{ $invoice->status == 'paid' ? 'check' : 'clock' }}"></i>
                            </div>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">
                                Invoice {{ $invoice->invoice_number }}
                            </div>
                            <div class="activity-subtitle">
                                {{ $invoice->customer->name }} • ${{ number_format($invoice->total_amount, 2) }}
                            </div>
                            <div class="activity-time">
                                {{ $invoice->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="activity-status">
                            <span class="status-badge status-{{ $invoice->status }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-users"></i>
                        Recent Customers
                    </h2>
                    <div class="section-actions">
                        <a href="{{ route('customers.index') }}" class="btn-outline-sm">View All</a>
                    </div>
                </div>
                
                <div class="customer-list">
                    @foreach(App\Models\Customer::latest()->take(5)->get() as $customer)
                    <div class="customer-item">
                        <div class="customer-avatar">
                            <div class="avatar-circle">{{ substr($customer->name, 0, 1) }}</div>
                        </div>
                        <div class="customer-content">
                            <div class="customer-name">{{ $customer->name }}</div>
                            <div class="customer-email">{{ $customer->email }}</div>
                            <div class="customer-time">{{ $customer->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="customer-action">
                            <a href="{{ route('customers.show', $customer) }}" class="btn-sm">View</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue',
                data: [
                    @foreach(range(1, 12) as $month) {
                        {
                            $monthlyRevenue - > where('month', $month) - > first() - > revenue ?? 0
                        }
                    },
                    @endforeach
                ],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Brand Chart
    const brandCtx = document.getElementById('brandChart').getContext('2d');
    const brandChart = new Chart(brandCtx, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($activationsByBrand as $brand)
                '{{ $brand->brand }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($activationsByBrand as $brand) {
                        {
                            $brand - > count
                        }
                    },
                    @endforeach
                ],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endpush

<style>
/* Welcome Section */
.welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
}

.welcome-content {
    flex: 1;
    min-width: 300px;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    line-height: 1.2;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 25px;
}

.welcome-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.welcome-stats {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Enhanced Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stat-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.stat-card.revenue .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.stat-card.customers .stat-icon { background: linear-gradient(135deg, #f093fb, #f5576c); }
.stat-card.activations .stat-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.stat-card.invoices .stat-icon { background: linear-gradient(135deg, #43e97b, #38f9d7); }

.stat-trend {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 20px;
}

.stat-trend.positive {
    background: #e8f5e8;
    color: #2d7d32;
}

.stat-trend.neutral {
    background: #fff3e0;
    color: #f57c00;
}

.stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: #1a1a1a;
}

.stat-label {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.stat-description {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 15px;
}

.stat-action .btn-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
}

/* Services Section */
.services-section {
    margin-bottom: 40px;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.service-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 20px;
    border: 1px solid #f0f0f0;
}

.service-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
}

.service-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    flex-shrink: 0;
}

.service-icon.customers { background: linear-gradient(135deg, #f093fb, #f5576c); }
.service-icon.invoices { background: linear-gradient(135deg, #667eea, #764ba2); }
.service-icon.activations { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.service-icon.orders { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.service-icon.reports { background: linear-gradient(135deg, #fa709a, #fee140); }
.service-icon.stock { background: linear-gradient(135deg, #a8edea, #fed6e3); color: #333; }

.service-content {
    flex: 1;
}

.service-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.service-description {
    font-size: 0.9rem;
    color: #666;
}

.btn-service {
    background: #f8f9fa;
    color: #333;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    border: 1px solid #e9ecef;
}

.btn-service:hover {
    background: #667eea;
    color: white;
    text-decoration: none;
}

/* Activity Lists */
.activity-list, .customer-list {
    space-y: 15px;
}

.activity-item, .customer-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.activity-item:last-child, .customer-item:last-child {
    border-bottom: none;
}

.activity-avatar, .customer-avatar {
    flex-shrink: 0;
}

.avatar-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    background: #667eea;
}

.avatar-circle.success { background: #28a745; }
.avatar-circle.warning { background: #ffc107; color: #333; }

.activity-content, .customer-content {
    flex: 1;
}

.activity-title, .customer-name {
    font-weight: 600;
    margin-bottom: 3px;
    color: #333;
}

.activity-subtitle, .customer-email {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 3px;
}

.activity-time, .customer-time {
    font-size: 0.8rem;
    color: #999;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.section-title i {
    color: #667eea;
}

.btn-outline-sm {
    padding: 6px 12px;
    font-size: 0.85rem;
    border: 1px solid #667eea;
    color: #667eea;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-outline-sm:hover {
    background: #667eea;
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-section {
        padding: 25px;
        text-align: center;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .welcome-stats {
        justify-content: center;
        width: 100%;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .services-grid {
        grid-template-columns: 1fr;
    }
    
    .service-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>
