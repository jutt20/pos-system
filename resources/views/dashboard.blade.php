@extends('layouts.app')

@section('title', 'Admin Portal Dashboard')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Admin Portal Dashboard</h1>
        <div class="header-actions">
            <a href="{{ route('customers.create') }}" class="btn-primary">Add Customer</a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Customers</div>
                <div class="stat-value">{{ $stats['total_customers'] }}</div>
            </div>
            <div class="stat-action">
                <a href="{{ route('customers.index') }}" class="btn-link">View All</a>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Balance</div>
                <div class="stat-value green">${{ number_format($stats['total_revenue'], 2) }}</div>
            </div>
            <div class="stat-action">
                <a href="{{ route('reports.index') }}" class="btn-link">View Reports</a>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Invoices</div>
                <div class="stat-value">{{ $stats['pending_invoices'] }}</div>
            </div>
            <div class="stat-action">
                <a href="{{ route('invoices.index') }}" class="btn-link">View All</a>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-sim-card"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Activations</div>
                <div class="stat-value">{{ $stats['total_activations'] }}</div>
            </div>
            <div class="stat-action">
                <a href="{{ route('activations.index') }}" class="btn-link">View All</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="content-section">
        <h2 class="section-title">Quick Actions</h2>
        <div class="quick-actions-grid">
            <a href="{{ route('customers.create') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="quick-action-title">Add Customer</div>
                <div class="quick-action-desc">Create a new customer account</div>
            </a>
            
            <a href="{{ route('invoices.create') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="quick-action-title">Create Invoice</div>
                <div class="quick-action-desc">Generate a new invoice</div>
            </a>
            
            <a href="{{ route('activations.create') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="quick-action-title">New Activation</div>
                <div class="quick-action-desc">Activate a new SIM card</div>
            </a>
            
            <a href="{{ route('sim-orders.create') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="quick-action-title">Order SIMs</div>
                <div class="quick-action-desc">Place a new SIM order</div>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-md-6">
            <div class="content-section">
                <h2 class="section-title">Recent Customers</h2>
                <div class="recent-items">
                    @foreach(App\Models\Customer::latest()->take(5)->get() as $customer)
                    <div class="recent-item">
                        <div class="recent-item-avatar">
                            <div class="avatar-circle">{{ substr($customer->name, 0, 1) }}</div>
                        </div>
                        <div class="recent-item-content">
                            <div class="recent-item-title">{{ $customer->name }}</div>
                            <div class="recent-item-subtitle">{{ $customer->email }}</div>
                        </div>
                        <div class="recent-item-action">
                            <a href="{{ route('customers.show', $customer) }}" class="btn-sm">View</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="content-section">
                <h2 class="section-title">Recent Invoices</h2>
                <div class="recent-items">
                    @foreach($recentInvoices as $invoice)
                    <div class="recent-item">
                        <div class="recent-item-avatar">
                            <div class="avatar-circle green">$</div>
                        </div>
                        <div class="recent-item-content">
                            <div class="recent-item-title">{{ $invoice->invoice_number }}</div>
                            <div class="recent-item-subtitle">{{ $invoice->customer->name }}</div>
                        </div>
                        <div class="recent-item-meta">
                            <div class="recent-item-amount">${{ number_format($invoice->total_amount, 2) }}</div>
                            <span class="status-badge {{ $invoice->status == 'paid' ? 'status-paid' : 'status-unpaid' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
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
                @foreach(range(1, 12) as $month)
                    {{ $monthlyRevenue->where('month', $month)->first()->revenue ?? 0 }},
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
                @foreach($activationsByBrand as $brand)
                    {{ $brand->count }},
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
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #6b7280;
}

.stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.stat-icon.blue {
    background: #dbeafe;
    color: #2563eb;
}

.stat-icon.purple {
    background: #f3e8ff;
    color: #9333ea;
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
}

.stat-value.green {
    color: #16a34a;
}

.stat-action {
    margin-left: auto;
}

.btn-link {
    color: #2563eb;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.btn-link:hover {
    text-decoration: underline;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.quick-action-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-decoration: none;
    color: inherit;
    transition: transform 0.2s, box-shadow 0.2s;
    text-align: center;
}

.quick-action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    text-decoration: none;
    color: inherit;
}

.quick-action-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #2563eb;
    margin: 0 auto 16px;
}

.quick-action-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.quick-action-desc {
    font-size: 14px;
    color: #6b7280;
}

.recent-items {
    space-y: 12px;
}

.recent-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-item-avatar .avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #374151;
}

.recent-item-avatar .avatar-circle.green {
    background: #dcfce7;
    color: #16a34a;
}

.recent-item-content {
    flex: 1;
}

.recent-item-title {
    font-weight: 500;
    margin-bottom: 2px;
}

.recent-item-subtitle {
    font-size: 14px;
    color: #6b7280;
}

.recent-item-meta {
    text-align: right;
}

.recent-item-amount {
    font-weight: 600;
    margin-bottom: 4px;
}
</style>
