@extends('layouts.app')

@section('title', 'SIM Orders Management')

@section('content')
<div class="main-container">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-shopping-cart me-2"></i>
                SIM Orders Management
            </h1>
            <p class="page-subtitle">Track and manage SIM card inventory orders</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('sim-orders.create') }}" class="btn-primary">
                <i class="fas fa-plus me-2"></i>
                Create Order
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ $orders->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Value</div>
                <div class="stat-value green">${{ number_format($orders->sum('total_cost'), 2) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-sim-card"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total SIMs</div>
                <div class="stat-value">{{ $orders->sum('quantity') }}</div>
            </div>
        </div>
    </div>

    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">All Orders</h2>
            <div class="section-actions">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-status="all">All Orders</button>
                    <button class="filter-tab" data-status="pending">Pending</button>
                    <button class="filter-tab" data-status="received">Received</button>
                    <button class="filter-tab" data-status="cancelled">Cancelled</button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Vendor</th>
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
                            <span class="order-id">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div class="vendor-info">
                                <div class="vendor-name">{{ $order->vendor }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="brand-badge brand-{{ strtolower($order->brand) }}">
                                {{ $order->brand }}
                            </span>
                        </td>
                        <td>
                            <span class="sim-type-badge">{{ $order->sim_type }}</span>
                        </td>
                        <td>
                            <span class="quantity-badge">{{ number_format($order->quantity) }}</span>
                        </td>
                        <td>${{ number_format($order->unit_cost, 2) }}</td>
                        <td class="text-success fw-bold">${{ number_format($order->total_cost, 2) }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('sim-orders.show', $order) }}" class="btn-sm btn-outline">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('sim-orders.edit', $order) }}" class="btn-sm btn-outline">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5>No Orders Found</h5>
                                <p class="text-muted">Start by creating your first SIM order</p>
                                <a href="{{ route('sim-orders.create') }}" class="btn-primary">
                                    <i class="fas fa-plus me-2"></i>
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
// Filter functionality
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const status = this.dataset.status;
        const rows = document.querySelectorAll('.data-table tbody tr[data-status]');
        
        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
