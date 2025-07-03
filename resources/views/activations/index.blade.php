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
            <p class="page-subtitle">Manage SIM card activations and track commissions</p>
        </div>
        <div class="header-actions">
            <div class="search-box me-3">
                <input type="text" class="form-control" placeholder="Search activations..." id="searchInput">
            </div>
            <a href="{{ route('activations.create') }}" class="btn-primary">
                <i class="fas fa-plus me-2"></i>
                Add Activation
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
                <div class="stat-change positive">+5 this week</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Profit</div>
                <div class="stat-value green">${{ number_format($activations->sum('profit'), 2) }}</div>
                <div class="stat-change positive">+12% this month</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Average Profit</div>
                <div class="stat-value">${{ $activations->count() > 0 ? number_format($activations->sum('profit') / $activations->count(), 2) : '0.00' }}</div>
                <div class="stat-change positive">Per activation</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Top Brand</div>
                <div class="stat-value">{{ $activations->groupBy('brand')->sortByDesc(function($group) { return $group->count(); })->keys()->first() ?? 'N/A' }}</div>
                <div class="stat-change">Most popular</div>
            </div>
        </div>
    </div>

    <!-- Activations Table -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-list me-2"></i>
                Recent Activations
            </h2>
            <div class="section-actions">
                <select class="form-select" id="brandFilter">
                    <option value="">All Brands</option>
                    @foreach($activations->pluck('brand')->unique() as $brand)
                        <option value="{{ $brand }}">{{ $brand }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="data-table" id="activationsTable">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Phone Number</th>
                        <th>Brand</th>
                        <th>Plan</th>
                        <th>Cost</th>
                        <th>Profit</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activations as $activation)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="width: 40px; height: 40px; font-size: 0.8rem;">
                                    {{ strtoupper(substr($activation->customer->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $activation->customer->name }}</div>
                                    <small class="text-muted">{{ $activation->customer->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $activation->phone_number }}</span>
                        </td>
                        <td>
                            <span class="badge" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); color: white;">
                                {{ $activation->brand }}
                            </span>
                        </td>
                        <td>{{ $activation->plan_name }}</td>
                        <td class="text-danger">${{ number_format($activation->cost, 2) }}</td>
                        <td class="text-success fw-bold">${{ number_format($activation->profit, 2) }}</td>
                        <td>{{ $activation->created_at->format('M j, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('activations.show', $activation) }}" class="btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('activations.edit', $activation) }}" class="btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No activations found</h5>
                                <p class="text-muted">Start by adding your first activation</p>
                                <a href="{{ route('activations.create') }}" class="btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Add First Activation
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
    const tableRows = document.querySelectorAll('#activationsTable tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Brand filter
document.getElementById('brandFilter').addEventListener('change', function() {
    const selectedBrand = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#activationsTable tbody tr');
    
    tableRows.forEach(row => {
        if (selectedBrand === '') {
            row.style.display = '';
        } else {
            const brandCell = row.cells[2].textContent.toLowerCase();
            row.style.display = brandCell.includes(selectedBrand) ? '' : 'none';
        }
    });
});
</script>
@endpush
