@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-section customer">
                <div class="welcome-content">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="welcome-logo me-3">
                        <div>
                            <h1 class="welcome-title mb-1">Welcome, {{ $customer->name }}!</h1>
                            <p class="welcome-subtitle mb-0">Manage your services and view your account information.</p>
                        </div>
                    </div>
                </div>
                <div class="welcome-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">${{ number_format($totalSpent, 2) }}</div>
                            <div class="stat-label">Total Spent</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">{{ $activeServices }}</div>
                            <div class="stat-label">Active Services</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card invoices">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $totalInvoices }}</div>
                        <div class="stats-label">Total Invoices</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card spent">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">${{ number_format($totalSpent, 2) }}</div>
                        <div class="stats-label">Total Spent</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card services">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $activeServices }}</div>
                        <div class="stats-label">Active Services</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card orders">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $pendingOrders }}</div>
                        <div class="stats-label">Pending Orders</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="section-title mb-4">
                <i class="fas fa-bolt me-2"></i>
                Quick Actions
            </h3>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('customer-portal.invoices') }}" class="service-card">
                <div class="service-icon invoices">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="service-content">
                    <h5>View Invoices</h5>
                    <p>Check your billing history and payments</p>
                </div>
                <div class="service-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('customer-portal.activations') }}" class="service-card">
                <div class="service-icon activations">
                    <i class="fas fa-sim-card"></i>
                </div>
                <div class="service-content">
                    <h5>My Activations</h5>
                    <p>View your active SIM cards and services</p>
                </div>
                <div class="service-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('customer-portal.orders') }}" class="service-card">
                <div class="service-icon orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="service-content">
                    <h5>Order History</h5>
                    <p>Track your orders and delivery status</p>
                </div>
                <div class="service-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="#" class="service-card">
                <div class="service-icon support">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="service-content">
                    <h5>Support Center</h5>
                    <p>Get help and contact customer support</p>
                </div>
                <div class="service-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="activity-card">
                <div class="activity-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-invoice me-2"></i>
                        Recent Invoices
                    </h5>
                </div>
                <div class="activity-body">
                    @if($recentInvoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentInvoices as $invoice)
                                    <tr>
                                        <td><strong>#{{ $invoice->invoice_number }}</strong></td>
                                        <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                        <td>${{ number_format($invoice->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No invoices found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="activity-card">
                <div class="activity-header">
                    <h5 class="mb-0">
                        <i class="fas fa-mobile-alt me-2"></i>
                        Recent Activations
                    </h5>
                </div>
                <div class="activity-body">
                    @if($recentActivations->count() > 0)
                        <div class="activation-list">
                            @foreach($recentActivations as $activation)
                            <div class="activation-item">
                                <div class="activation-icon">
                                    <i class="fas fa-sim-card"></i>
                                </div>
                                <div class="activation-content">
                                    <div class="activation-title">{{ $activation->sim_number }}</div>
                                    <div class="activation-plan">{{ $activation->plan_name }}</div>
                                    <div class="activation-date">{{ $activation->created_at->format('M d, Y') }}</div>
                                </div>
                                <div class="activation-status">
                                    <span class="badge bg-{{ $activation->status == 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($activation->status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No activations found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-section.customer {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.welcome-logo {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.welcome-stats {
    display: flex;
    gap: 2rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

.stats-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.stats-card-body {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stats-card.invoices .stats-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.stats-card.spent .stats-icon { background: linear-gradient(135deg, #f093fb, #f5576c); }
.stats-card.services .stats-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.stats-card.orders .stats-icon { background: linear-gradient(135deg, #43e97b, #38f9d7); }

.stats-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2d3748;
}

.stats-label {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.section-title {
    color: #2d3748;
    font-weight: 700;
    font-size: 1.5rem;
}

.service-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
    height: 100%;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    text-decoration: none;
    color: inherit;
}

.service-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.service-icon.invoices { background: linear-gradient(135deg, #667eea, #764ba2); }
.service-icon.activations { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.service-icon.orders { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.service-icon.support { background: linear-gradient(135deg, #f093fb, #f5576c); }

.service-content h5 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2d3748;
}

.service-content p {
    color: #718096;
    margin: 0;
    font-size: 0.9rem;
}

.service-arrow {
    margin-left: auto;
    color: #cbd5e0;
    font-size: 1.2rem;
}

.activity-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    height: 100%;
}

.activity-header {
    padding: 1.5rem 1.5rem 0;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 1.5rem;
}

.activity-header h5 {
    color: #2d3748;
    font-weight: 600;
}

.activity-body {
    padding: 0 1.5rem 1.5rem;
}

.activation-list {
    max-height: 400px;
    overflow-y: auto;
}

.activation-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f7fafc;
}

.activation-item:last-child {
    border-bottom: none;
}

.activation-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.activation-content {
    flex: 1;
}

.activation-title {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.activation-plan {
    color: #4a5568;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.activation-date {
    color: #718096;
    font-size: 0.8rem;
}

.activation-status {
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .welcome-section.customer {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .welcome-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .service-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endsection
