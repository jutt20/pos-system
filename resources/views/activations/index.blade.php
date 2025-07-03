@extends('layouts.app')

@section('title', 'Activations Management')

@section('content')
<div class="main-container">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-mobile-alt me-2"></i>
                Activations Management
            </h1>
            <p class="page-subtitle">Manage SIM card activations and track profits</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('activations.create') }}" class="btn-primary">
                <i class="fas fa-plus me-2"></i>
                New Activation
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Activations</div>
                <div class="stat-value">{{ $activations->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value green">${{ number_format($activations->sum('total_cost'), 2) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Profit</div>
                <div class="stat-value">${{ number_format($activations->sum('profit'), 2) }}</div>
            </div>
        </div>
    </div>

    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">All Activations</h2>
            <div class="section-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search activations..." id="searchInput">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Plan</th>
                        <th>Brand</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Cost</th>
                        <th>Profit</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activations as $activation)
                    <tr>
                        <td>
                            <div class="customer-info">
                                <div class="customer-avatar">
                                    {{ substr($activation->customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="customer-name">{{ $activation->customer->name }}</div>
                                    <div class="customer-email">{{ $activation->customer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="plan-badge">{{ $activation->plan }}</span>
                        </td>
                        <td>
                            <span class="brand-badge brand-{{ strtolower($activation->brand) }}">
                                {{ $activation->brand }}
                            </span>
                        </td>
                        <td><code>{{ $activation->sku }}</code></td>
                        <td>
                            <span class="quantity-badge">{{ $activation->quantity }}</span>
                        </td>
                        <td>${{ number_format($activation->price, 2) }}</td>
                        <td class="text-success fw-bold">${{ number_format($activation->total_cost, 2) }}</td>
                        <td class="text-primary fw-bold">${{ number_format($activation->profit, 2) }}</td>
                        <td>{{ $activation->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('activations.show', $activation) }}" class="btn-sm btn-outline">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('activations.edit', $activation) }}" class="btn-sm btn-outline">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                                <h5>No Activations Found</h5>
                                <p class="text-muted">Start by creating your first activation</p>
                                <a href="{{ route('activations.create') }}" class="btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Create First Activation
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
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('.data-table tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endpush
