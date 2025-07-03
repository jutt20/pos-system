@extends('layouts.app')

@section('title', 'SIM Orders')

@section('content')
<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-shopping-cart"></i>
                SIM Orders Management
            </h1>
            <p class="page-subtitle">Manage and track all SIM card purchase orders</p>
        </div>
        <div class="header-actions">
            @can('manage orders')
            <a href="{{ route('sim-orders.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i>
                New SIM Order
            </a>
            @endcan
            <button class="btn-secondary" onclick="exportOrders()">
                <i class="fas fa-download"></i>
                Export
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value blue">{{ $orders->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +12% from last month
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Delivered Orders</div>
                <div class="stat-value green">{{ $orders->where('status', 'delivered')->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +8% from last month
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value">{{ $orders->where('status', 'pending')->count() }}</div>
                <div class="stat-change">
                    <i class="fas fa-minus"></i> No change
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Value</div>
                <div class="stat-value">${{ number_format($orders->sum('total_cost'), 2) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +15% from last month
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-filter"></i>
                Filter & Search Orders
            </h2>
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="search-box">
                    <input type="text" class="form-control" id="searchOrders" placeholder="Search orders...">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="brandFilter">
                    <option value="">All Brands</option>
                    @foreach($orders->pluck('brand')->unique() as $brand)
                    <option value="{{ $brand }}">{{ $brand }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="customerFilter">
                    <option value="">All Customers</option>
                    @foreach($orders->pluck('customer.name')->unique() as $customerName)
                    <option value="{{ $customerName }}">{{ $customerName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-list"></i>
                SIM Orders List
            </h2>
            <div class="section-actions">
                <span class="badge bg-primary">{{ $orders->count() }} Total Orders</span>
            </div>
        </div>

        @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="data-table" id="ordersTable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Brand</th>
                        <th>SIM Type</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Total Cost</th>
                        <th>Vendor</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <strong>#{{ $order->id }}</strong>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    @if($order->customer)
                                        {{ strtoupper(substr($order->customer->name, 0, 2)) }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-semibold">
                                        @if($order->customer)
                                            {{ $order->customer->name }}
                                        @else
                                            <span class="text-muted">No Customer</span>
                                        @endif
                                    </div>
                                    @if($order->customer && $order->customer->email)
                                    <small class="text-muted">{{ $order->customer->email }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">
                                {{ $order->brand }}
                            </span>
                        </td>
                        <td>{{ $order->sim_type }}</td>
                        <td>
                            <span class="fw-bold">{{ number_format($order->quantity) }}</span>
                        </td>
                        <td>${{ number_format($order->unit_cost, 2) }}</td>
                        <td>
                            <span class="fw-bold text-success">${{ number_format($order->total_cost, 2) }}</span>
                        </td>
                        <td>{{ $order->vendor }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="status-badge status-pending">Pending</span>
                            @elseif($order->status == 'delivered')
                                <span class="status-badge status-delivered">Delivered</span>
                            @elseif($order->status == 'cancelled')
                                <span class="status-badge status-cancelled">Cancelled</span>
                            @else
                                <span class="status-badge">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $order->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('sim-orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('manage orders')
                                <a href="{{ route('sim-orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary" title="Edit Order">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('sim-orders.destroy', $order) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-shopping-cart fa-4x"></i>
            <h5>No SIM Orders Found</h5>
            <p>There are no SIM orders in the system yet.</p>
            @can('manage orders')
            <a href="{{ route('sim-orders.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i>
                Create First Order
            </a>
            @endcan
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchOrders').addEventListener('keyup', function() {
        filterTable();
    });

    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
        filterTable();
    });

    document.getElementById('brandFilter').addEventListener('change', function() {
        filterTable();
    });

    document.getElementById('customerFilter').addEventListener('change', function() {
        filterTable();
    });

    function filterTable() {
        const searchTerm = document.getElementById('searchOrders').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const brandFilter = document.getElementById('brandFilter').value.toLowerCase();
        const customerFilter = document.getElementById('customerFilter').value.toLowerCase();
        
        const table = document.getElementById('ordersTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let showRow = true;

            // Search filter
            if (searchTerm) {
                const rowText = row.textContent.toLowerCase();
                if (!rowText.includes(searchTerm)) {
                    showRow = false;
                }
            }

            // Status filter
            if (statusFilter && showRow) {
                const statusCell = cells[8].textContent.toLowerCase();
                if (!statusCell.includes(statusFilter)) {
                    showRow = false;
                }
            }

            // Brand filter
            if (brandFilter && showRow) {
                const brandCell = cells[2].textContent.toLowerCase();
                if (!brandCell.includes(brandFilter)) {
                    showRow = false;
                }
            }

            // Customer filter
            if (customerFilter && showRow) {
                const customerCell = cells[1].textContent.toLowerCase();
                if (!customerCell.includes(customerFilter)) {
                    showRow = false;
                }
            }

            row.style.display = showRow ? '' : 'none';
        }
    }

    function clearFilters() {
        document.getElementById('searchOrders').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('brandFilter').value = '';
        document.getElementById('customerFilter').value = '';
        filterTable();
    }

    function exportOrders() {
        // This would typically trigger an export
        alert('Export functionality would be implemented here');
    }
</script>
@endpush
@endsection
