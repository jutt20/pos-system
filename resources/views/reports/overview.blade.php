@extends('layouts.app')

@section('title', 'Reports Overview')

@section('content')
<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-chart-line"></i>
                Employee Portal UI - Reports Overview
            </h1>
            <p class="page-subtitle">Admin Portal - Nexitel Overview & Analytics</p>
        </div>
        <div class="header-actions">
            <button class="btn-secondary" onclick="exportOverview()">
                <i class="fas fa-download"></i>
                Export Overview
            </button>
            <button class="btn-primary" onclick="refreshData()">
                <i class="fas fa-sync-alt"></i>
                Refresh Data
            </button>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="content-section">
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="#overview" data-bs-toggle="tab">
                    <i class="fas fa-chart-bar"></i> Overview
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#customer-details" data-bs-toggle="tab">
                    <i class="fas fa-users"></i> Customer Details
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview">
                <!-- Admin Portal - Nexitel Overview -->
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-tachometer-alt"></i>
                        Admin Portal - Nexitel Overview
                    </h2>
                </div>
                
                <!-- Stats Grid -->
                <div class="stats-grid mb-4">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Total Activations</div>
                            <div class="stat-value blue">140</div>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i> +12% from last month
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Total Revenue</div>
                            <div class="stat-value green">$2,300.00</div>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i> +8% from last month
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Total Profit</div>
                            <div class="stat-value">$1,100.00</div>
                            <div class="stat-change positive">
                                <i class="fas fa-arrow-up"></i> +15% from last month
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activations by SKU & Brand -->
                <div class="mb-4">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-mobile-alt"></i>
                            Activations by SKU & Brand
                        </h3>
                        <div class="section-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="exportActivations()">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Plan</th>
                                    <th>SKU</th>
                                    <th>Customer</th>
                                    <th>Quantity</th>
                                    <th>Selling Price</th>
                                    <th>Vendor Cost</th>
                                    <th>Total</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">
                                            Nexitel Blue
                                        </span>
                                    </td>
                                    <td>Unlimited Talk</td>
                                    <td><code>SKU-BLUE-001</code></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                JD
                                            </div>
                                            <div>
                                                <div class="fw-semibold">John Doe</div>
                                                <small class="text-muted">john@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="fw-bold">100</span></td>
                                    <td>$15.00</td>
                                    <td>$10.00</td>
                                    <td><span class="fw-bold text-success">$1,500.00</span></td>
                                    <td><span class="fw-bold text-success">$500.00</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
                                            Nexitel Purple
                                        </span>
                                    </td>
                                    <td>Premium Plan</td>
                                    <td><code>SKU-PURPLE-002</code></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                JS
                                            </div>
                                            <div>
                                                <div class="fw-semibold">Jane Smith</div>
                                                <small class="text-muted">jane@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="fw-bold">40</span></td>
                                    <td>$20.00</td>
                                    <td>$15.00</td>
                                    <td><span class="fw-bold text-success">$800.00</span></td>
                                    <td><span class="fw-bold text-success">$200.00</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SIM Purchase Orders by Network -->
                <div class="mb-4">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-shopping-cart"></i>
                            SIM Purchase Orders by Network
                        </h3>
                        <div class="section-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="exportOrders()">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Network</th>
                                    <th>SIM Type</th>
                                    <th>Customer</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">
                                            Nexitel Blue
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">AT&T</span>
                                    </td>
                                    <td>Standard SIM</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                JD
                                            </div>
                                            <span class="fw-semibold">John Doe</span>
                                        </div>
                                    </td>
                                    <td><span class="fw-bold">300</span></td>
                                    <td>
                                        <div>Jun 01, 2025</div>
                                        <small class="text-muted">10:30 AM</small>
                                    </td>
                                    <td>
                                        <span class="status-badge status-delivered">Delivered</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
                                            Nexitel Purple
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">T-Mobile</span>
                                    </td>
                                    <td>eSIM</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                JS
                                            </div>
                                            <span class="fw-semibold">Jane Smith</span>
                                        </div>
                                    </td>
                                    <td><span class="fw-bold">150</span></td>
                                    <td>
                                        <div>Jun 03, 2025</div>
                                        <small class="text-muted">2:15 PM</small>
                                    </td>
                                    <td>
                                        <span class="status-badge status-pending">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Customer Details Tab -->
            <div class="tab-pane fade" id="customer-details">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-users"></i>
                        Customer Details & Analytics
                    </h3>
                </div>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Total Orders</th>
                                        <th>Total Spent</th>
                                        <th>Last Order</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3" style="width: 40px; height: 40px;">
                                                    JD
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">John Doe</div>
                                                    <small class="text-muted">john@example.com</small>
                                                    <div><small class="text-muted">+1 (555) 123-4567</small></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">5</span></td>
                                        <td><span class="fw-bold text-success">$1,500.00</span></td>
                                        <td>
                                            <div>Jun 01, 2025</div>
                                            <small class="text-muted">2 days ago</small>
                                        </td>
                                        <td>
                                            <span class="status-badge status-active">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3" style="width: 40px; height: 40px;">
                                                    JS
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">Jane Smith</div>
                                                    <small class="text-muted">jane@example.com</small>
                                                    <div><small class="text-muted">+1 (555) 987-6543</small></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">3</span></td>
                                        <td><span class="fw-bold text-success">$800.00</span></td>
                                        <td>
                                            <div>Jun 03, 2025</div>
                                            <small class="text-muted">Today</small>
                                        </td>
                                        <td>
                                            <span class="status-badge status-active">Active</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="quick-stats">
                            <div class="quick-stat-item">
                                <div class="quick-stat-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="quick-stat-content">
                                    <div class="quick-stat-value">2</div>
                                    <div class="quick-stat-label">Active Customers</div>
                                </div>
                            </div>
                            
                            <div class="quick-stat-item">
                                <div class="quick-stat-icon bg-success">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="quick-stat-content">
                                    <div class="quick-stat-value">$1,150</div>
                                    <div class="quick-stat-label">Avg Customer Value</div>
                                </div>
                            </div>
                            
                            <div class="quick-stat-item">
                                <div class="quick-stat-icon bg-info">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="quick-stat-content">
                                    <div class="quick-stat-value">4</div>
                                    <div class="quick-stat-label">Avg Orders per Customer</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function exportOverview() {
        // Create a form and submit it to trigger the export
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route("reports.export") }}';
        
        const typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = 'type';
        typeInput.value = 'overview';
        
        form.appendChild(typeInput);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    function exportActivations() {
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route("reports.export") }}';
        
        const typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = 'type';
        typeInput.value = 'activations';
        
        form.appendChild(typeInput);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    function exportOrders() {
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route("reports.export") }}';
        
        const typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = 'type';
        typeInput.value = 'orders';
        
        form.appendChild(typeInput);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    function refreshData() {
        location.reload();
    }
</script>
@endpush
@endsection
