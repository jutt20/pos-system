@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-section">
                <div class="welcome-content">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="welcome-logo me-3">
                        <div>
                            <h1 class="welcome-title mb-1">Welcome back, {{ Auth::user()->name }}!</h1>
                            <p class="welcome-subtitle mb-0">Here's what's happening with your business today.</p>
                        </div>
                    </div>
                </div>
                <div class="welcome-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">{{ number_format($totalRevenue, 2) }}</div>
                            <div class="stat-label">Total Revenue</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">{{ $totalCustomers }}</div>
                            <div class="stat-label">Total Customers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card revenue">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">${{ number_format($totalRevenue, 2) }}</div>
                        <div class="stats-label">Total Revenue</div>
                        <div class="stats-trend positive">
                            <i class="fas fa-arrow-up"></i> 12.5%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card customers">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $totalCustomers }}</div>
                        <div class="stats-label">Total Customers</div>
                        <div class="stats-trend positive">
                            <i class="fas fa-arrow-up"></i> 8.2%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card activations">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-sim-card"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $totalActivations }}</div>
                        <div class="stats-label">Active SIMs</div>
                        <div class="stats-trend positive">
                            <i class="fas fa-arrow-up"></i> 15.3%
                        </div>
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
                        <div class="stats-value">{{ $totalOrders }}</div>
                        <div class="stats-label">Total Orders</div>
                        <div class="stats-trend positive">
                            <i class="fas fa-arrow-up"></i> 6.7%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="section-title mb-4">
                <i class="fas fa-cogs me-2"></i>
                Quick Services
            </h3>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('customers.index') }}" class="service-card">
                <div class="service-icon customers">
                    <i class="fas fa-users"></i>
                </div>
                <div class="service-content">
                    <h5>Customer Management</h5>
                    <p>Manage customer accounts and information</p>
                </div>
                <div class="service-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('invoices.index') }}" class="service-card">
                <div class="service-icon invoices">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="service-content">
                    <h5>Invoice Management</h5>
                    <p>Create and manage customer invoices</p>
                </div>
                <div class="service-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('sim-stocks.index') }}" class="service-card">
                <div class="service-icon sim-stock">
                    <i class="fas fa-sim-card"></i>
                </div>
                <div class="service-content">
                    <h5>SIM Stock Management</h5>
                    <p>Track and manage SIM card inventory</p>
                </div>
                <div class="service-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('activations.index') }}" class="service-card">
                <div class="service-icon activations">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="service-content">
                    <h5>SIM Activations</h5>
                    <p>Activate and manage SIM cards</p>
                </div>
                <div class="service-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Activity and Charts -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="activity-card">
                <div class="activity-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-area me-2"></i>
                        Revenue Overview
                    </h5>
                </div>
                <div class="activity-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="activity-card">
                <div class="activity-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="activity-body">
                    <div class="activity-list">
                        @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon {{ $activity['type'] }}">
                                <i class="fas {{ $activity['icon'] }}"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $activity['title'] }}</div>
                                <div class="activity-time">{{ $activity['time'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

.stats-card.revenue .stats-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.stats-card.customers .stats-icon { background: linear-gradient(135deg, #f093fb, #f5576c); }
.stats-card.activations .stats-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
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

.stats-trend {
    font-size: 0.8rem;
    font-weight: 600;
}

.stats-trend.positive { color: #48bb78; }
.stats-trend.negative { color: #f56565; }

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

.service-icon.customers { background: linear-gradient(135deg, #f093fb, #f5576c); }
.service-icon.invoices { background: linear-gradient(135deg, #667eea, #764ba2); }
.service-icon.sim-stock { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.service-icon.activations { background: linear-gradient(135deg, #43e97b, #38f9d7); }

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

.activity-list {
    max-height: 300px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f7fafc;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    color: white;
}

.activity-icon.customer { background: linear-gradient(135deg, #f093fb, #f5576c); }
.activity-icon.invoice { background: linear-gradient(135deg, #667eea, #764ba2); }
.activity-icon.activation { background: linear-gradient(135deg, #43e97b, #38f9d7); }

.activity-title {
    font-weight: 500;
    color: #2d3748;
    font-size: 0.9rem;
}

.activity-time {
    color: #718096;
    font-size: 0.8rem;
}

@media (max-width: 768px) {
    .welcome-section {
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($monthlyRevenue) !!},
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
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
                    color: 'rgba(0,0,0,0.05)'
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
</script>
@endsection
