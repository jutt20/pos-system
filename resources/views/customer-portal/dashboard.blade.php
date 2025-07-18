@extends('layouts.app')

@section('title', 'Customer Portal')

@section('content')
<div class="main-container">
    <!-- Welcome Header -->
    <div class="welcome-section customer-portal">
        <div class="welcome-content">
            <h1 class="welcome-title">Welcome, {{ $customer->name }}</h1>
            <p class="welcome-subtitle">Manage your account and services</p>
        </div>
        <div class="welcome-stats">
            <div class="stat-item">
                <div class="stat-number">${{ number_format($customer->balance, 2) }}</div>
                <div class="stat-label">Account Balance</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['active_services'] }}</div>
                <div class="stat-label">Active Services</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['total_orders'] }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
        </div>
    </div>

    <!-- Account Summary -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-user-circle"></i>
            Account Summary
        </h2>
        <div class="account-grid">
            <div class="account-item">
                <div class="account-label">Email</div>
                <div class="account-value">{{ $customer->email }}</div>
            </div>
            <div class="account-item">
                <div class="account-label">Phone</div>
                <div class="account-value">{{ $customer->phone ?: 'Not provided' }}</div>
            </div>
            <div class="account-item">
                <div class="account-label">Account Type</div>
                <div class="account-value">
                    <span class="badge bg-{{ $customer->prepaid_status == 'prepaid' ? 'success' : 'info' }}">
                        {{ ucfirst($customer->prepaid_status) }}
                    </span>
                </div>
            </div>
            <div class="account-item">
                <div class="account-label">Member Since</div>
                <div class="account-value">{{ $customer->created_at->format('M d, Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Services Overview -->
    <div class="services-section">
        <h2 class="section-title">
            <i class="fas fa-mobile-alt"></i>
            Your Services
        </h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon activations">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">Active Services</div>
                    <div class="service-description">{{ $stats['active_services'] }} active SIM services</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('customer-portal.activations') }}" class="btn-service">View All</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">SIM Orders</div>
                    <div class="service-description">{{ $stats['total_orders'] }} total orders placed</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('customer-portal.orders') }}" class="btn-service">View Orders</a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon invoices">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="service-content">
                    <div class="service-title">Invoices</div>
                    <div class="service-description">${{ number_format($stats['total_spent'], 2) }} total spent</div>
                </div>
                <div class="service-action">
                    <a href="{{ route('customer-portal.invoices') }}" class="btn-service">View Invoices</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-6">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-mobile-alt"></i>
                        Recent Activations
                    </h2>
                    <div class="section-actions">
                        <a href="{{ route('customer-portal.activations') }}" class="btn-outline-sm">View All</a>
                    </div>
                </div>
                
                @if($activations->count() > 0)
                <div class="activity-list">
                    @foreach($activations->take(5) as $activation)
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <div class="avatar-circle {{ $activation->status == 'active' ? 'success' : 'warning' }}">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $activation->plan_name }}</div>
                            <div class="activity-subtitle">{{ $activation->brand }} • ${{ number_format($activation->cost, 2) }}</div>
                            <div class="activity-time">{{ $activation->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="activity-status">
                            <span class="status-badge status-{{ $activation->status }}">
                                {{ ucfirst($activation->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-mobile-alt fa-3x text-muted"></i>
                    <h5>No Activations Yet</h5>
                    <p class="text-muted">Your SIM activations will appear here</p>
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-file-invoice"></i>
                        Recent Invoices
                    </h2>
                    <div class="section-actions">
                        <a href="{{ route('customer-portal.invoices') }}" class="btn-outline-sm">View All</a>
                    </div>
                </div>
                
                @if($invoices->count() > 0)
                <div class="activity-list">
                    @foreach($invoices as $invoice)
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <div class="avatar-circle {{ $invoice->status == 'paid' ? 'success' : 'warning' }}">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $invoice->invoice_number }}</div>
                            <div class="activity-subtitle">${{ number_format($invoice->total_amount, 2) }}</div>
                            <div class="activity-time">{{ $invoice->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="activity-status">
                            <span class="status-badge status-{{ $invoice->status }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-file-invoice fa-3x text-muted"></i>
                    <h5>No Invoices Yet</h5>
                    <p class="text-muted">Your invoices will appear here</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.customer-portal {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.account-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.account-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.account-label {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 8px;
    font-weight: 500;
}

.account-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #666;
}

.empty-state h5 {
    margin: 15px 0 10px;
    color: #333;
}
</style>
@endsection
