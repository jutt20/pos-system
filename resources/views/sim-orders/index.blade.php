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
            <p class="page-subtitle">Track and manage SIM card orders and inventory</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('sim-orders.create') }}" class="btn-primary">
                <i class="fas fa-plus me-2"></i>
                Create Order
            </a>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="content-section mb-4">
        <ul class="nav nav-pills" id="orderTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                    <i class="fas fa-list me-2"></i>All Orders ({{ $orders->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button" role="tab">
                    <i class="fas fa-clock me-2"></i>Pending ({{ $orders->where('status', 'pending')->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="delivered-tab" data-bs-toggle="pill" data-bs-target="#delivered" type="button" role="tab">
                    <i class="fas fa-check me-2"></i>Delivered ({{ $orders->where('status', 'delivered')->count() }})
                </button>
            </li>
        </ul>
    </div>

    <!-- Orders Content -->
    <div class="content-section">
        <div class="tab-content" id="orderTabsContent">
            <!-- All Orders -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Brand</th>
                                <th>Quantity</th>
                                <th>Total Cost</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
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
                                <td>
                                    <span class="badge bg-secondary">{{ $order->quantity }} SIMs</span>
                                </td>
                                <td class="fw-bold">${{ number_format($order->total_cost, 2) }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="status-badge" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e;">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                    @elseif($order->status == 'delivered')
                                        <span class="status-badge status-paid">
                                            <i class="fas fa-check me-1"></i>Delivered
                                        </span>
                                    @else
                                        <span class="status-badge status-unpaid">
                                            <i class="fas fa-times me-1"></i>{{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('sim-orders.show', $order) }}" class="btn-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('sim-orders.edit', $order) }}" class="btn-sm" title="Edit Order">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No orders found</h5>
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

            <!-- Pending Orders -->
            <div class="tab-pane fade" id="pending" role="tabpanel">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Brand</th>
                                <th>Quantity</th>
                                <th>Total Cost</th>
                                <th>Order Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders->where('status', 'pending') as $order)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
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
                                <td>
                                    <span class="badge bg-secondary">{{ $order->quantity }} SIMs</span>
                                </td>
                                <td class="fw-bold">${{ number_format($order->total_cost, 2) }}</td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('sim-orders.show', $order) }}" class="btn-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('sim-orders.edit', $order) }}" class="btn-sm" title="Edit Order">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No pending orders</h5>
                                        <p class="text-muted">All orders have been processed</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Delivered Orders -->
            <div class="tab-pane fade" id="delivered" role="tabpanel">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Brand</th>
                                <th>Quantity</th>
                                <th>Total Cost</th>
                                <th>Delivered Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders->where('status', 'delivered') as $order)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
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
                                <td>
                                    <span class="badge bg-secondary">{{ $order->quantity }} SIMs</span>
                                </td>
                                <td class="fw-bold">${{ number_format($order->total_cost, 2) }}</td>
                                <td>{{ $order->updated_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('sim-orders.show', $order) }}" class="btn-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-check fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No delivered orders</h5>
                                        <p class="text-muted">Orders will appear here once delivered</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.nav-pills .nav-link {
    background: transparent;
    border: 1px solid #e5e7eb;
    color: #6b7280;
    margin-right: 8px;
    border-radius: 8px;
    padding: 12px 20px;
    transition: all 0.2s;
}

.nav-pills .nav-link:hover {
    background: #f9fafb;
    color: #374151;
    border-color: #d1d5db;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-color: #3b82f6;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.empty-state {
    padding: 40px 20px;
}

.empty-state i {
    opacity: 0.5;
}
</style>
@endpush
