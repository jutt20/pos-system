@extends('layouts.app')

@section('title', 'SIM Orders Management')

@section('content')
<div class="main-container">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-shopping-cart"></i>
                SIM Orders Management
            </h1>
            <p class="page-subtitle">Track and manage SIM card orders and inventory</p>
        </div>
        <div class="header-actions">
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Search orders..." id="searchInput">
            </div>
            <a href="{{ route('sim-orders.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i>
                Create Order
            </a>
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
                <div class="stat-value">{{ $orders->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    +5 this week
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Value</div>
                <div class="stat-value green">${{ number_format($orders->sum('total_cost'), 2) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    +12% this month
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-sim-card"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total SIMs</div>
                <div class="stat-value">{{ number_format($orders->sum('quantity')) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    Inventory count
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
                    Awaiting delivery
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="content-section">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-list"></i>
                All Orders
            </h3>
            <div class="section-actions">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="ordersTable">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Brand</th>
                        <th>SIM Type</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr data-status="{{ $order->status }}">
                        <td>
                            <span class="fw-bold text-primary">
                                #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="width: 40px; height: 40px; font-size: 0.8rem;">
                                    {{ strtoupper(substr($order->customer->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $order->customer->name }}</div>
                                    <small class="text-muted">{{ $order->customer->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); color: white;">
                                {{ $order->brand }}
                            </span>
                        </td>
                        <td>{{ $order->sim_type }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ number_format($order->quantity) }}</span>
                        </td>
                        <td>${{ number_format($order->unit_cost, 2) }}</td>
                        <td class="fw-bold text-success">${{ number_format($order->total_cost, 2) }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M j, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('sim-orders.show', $order) }}" class="btn-sm btn-outline" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('sim-orders.edit', $order) }}" class="btn-sm btn-outline" title="Edit Order">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-shopping-cart fa-3x"></i>
                                <h5>No orders found</h5>
                                <p>Start by creating your first SIM order</p>
                                <a href="{{ route('sim-orders.create') }}" class="btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Create First Order
                                </a>
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
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#ordersTable tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function() {
    const selectedStatus = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#ordersTable tbody tr[data-status]');
    
    tableRows.forEach(row => {
        if (selectedStatus === '') {
            row.style.display = '';
        } else {
            const status = row.getAttribute('data-status');
            row.style.display = status === selectedStatus ? '' : 'none';
        }
    });
});
</script>
@endpush
