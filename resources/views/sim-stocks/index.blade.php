@extends('layouts.app')

@section('title', 'SIM Stocks')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3 mb-4" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-sim-card"></i>
                SIM Stock Management
            </h1>
            <p class="page-subtitle">Manage Nexitel SIM cards inventory and tracking</p>
        </div>
        <div class="header-actions d-flex align-items-center gap-2 flex-wrap">
            @can('manage sim stock')
            <a href="{{ route('sim-stocks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New SIM Stock
            </a>

            <form action="{{ route('sim-stocks.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2" style="margin: 0;">
                @csrf
                <label class="btn btn-outline-secondary mb-0">
                    <i class="fas fa-file-upload me-1"></i> Import Excel
                    <input type="file" name="import_file" required accept=".csv,.xlsx,.xls" style="display: none;" onchange="this.form.submit()">
                </label>
            </form>
            @endcan

            <a href="{{ route('sim-stocks.export') }}" class="btn btn-outline-info">
                <i class="fas fa-download"></i> Export
            </a>
        </div>
    </div>

    <!-- Category Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <h6 class="text-primary mb-3">
                <i class="fas fa-chart-pie"></i> SIM Categories Overview
            </h6>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle me-2" style="width: 20px; height: 20px; background-color: #8B5CF6;"></div>
                        <h6 class="mb-0">Nexitel Purple</h6>
                    </div>
                    <h4 class="text-primary">{{ $stats['nexitel_purple'] }}</h4>
                    <small class="text-muted">Physical & eSIM</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle me-2" style="width: 20px; height: 20px; background-color: #3B82F6;"></div>
                        <h6 class="mb-0">Nexitel Blue</h6>
                    </div>
                    <h4 class="text-info">{{ $stats['nexitel_blue'] }}</h4>
                    <small class="text-muted">Physical & eSIM</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle me-2" style="width: 20px; height: 20px; background-color: #10B981;"></div>
                        <h6 class="mb-0">eSIM Only</h6>
                    </div>
                    <h4 class="text-success">{{ $stats['esims'] }}</h4>
                    <small class="text-muted">Electronic SIM</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        <h6 class="mb-0">Low Stock</h6>
                    </div>
                    <h4 class="text-warning">{{ $stats['low_stock'] }}</h4>
                    <small class="text-muted">Need Restock</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-sim-card"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Stock</div>
                <div class="stat-value blue">{{ $stats['total'] }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> All SIM cards
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Available</div>
                <div class="stat-value green">{{ $stats['available'] }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> Ready to use
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">In Use</div>
                <div class="stat-value">{{ $stats['used'] }}</div>
                <div class="stat-change">
                    <i class="fas fa-minus"></i> Active SIMs
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Value</div>
                <div class="stat-value">${{ number_format($simStocks->sum('cost'), 2) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> Inventory value
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <form method="GET" action="{{ route('sim-stocks.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search SIM Number, ICCID, or Batch" value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $key => $category)
                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                        {{ $category['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used</option>
                <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                <option value="damaged" {{ request('status') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100"><i class="fas fa-search"></i> Search</button>
        </div>

        <div class="col-md-2">
            <a href="{{ route('sim-stocks.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-times"></i> Clear
            </a>
        </div>
    </form>

    <!-- SIM Stock Table -->
    <div class="content-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-list"></i> SIM Stock List
            </h2>
            <div class="section-actions">
                <span class="badge bg-primary">{{ $simStocks->total() }} Total SIMs</span>
            </div>
        </div>

        @if($simStocks->count() > 0)
        <div class="table-responsive">
            <table class="data-table" id="simStockTable">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th>ID</th>
                        <th>Category</th>
                        <th>SIM Number</th>
                        <th>ICCID</th>
                        <th>Type</th>
                        <th>Cost</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Batch ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($simStocks as $sim)
                    <tr>
                        <td>
                            <input type="checkbox" name="sim_ids[]" value="{{ $sim->id }}" class="form-check-input sim-checkbox">
                        </td>
                        <td>{{ $sim->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-2" style="width: 15px; height: 15px; background-color: {{ $sim->color_code }};"></div>
                                <span class="small">{{ $sim->category_info['name'] ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td>{{ $sim->sim_number ?: 'N/A' }}</td>
                        <td>
                            <code class="small">{{ $sim->iccid }}</code>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $sim->sim_type }}</span>
                        </td>
                        <td>${{ number_format($sim->cost, 2) }}</td>
                        <td>
                            <span class="badge {{ $sim->isLowStock() ? 'bg-warning' : 'bg-info' }}">
                                {{ $sim->stock_level }}
                            </span>
                            @if($sim->isLowStock())
                                <i class="fas fa-exclamation-triangle text-warning ms-1" title="Low Stock"></i>
                            @endif
                        </td>
                        <td>
                            <span class="badge
                                @if($sim->status == 'available') bg-success
                                @elseif($sim->status == 'used') bg-primary
                                @elseif($sim->status == 'reserved') bg-info
                                @elseif($sim->status == 'sold') bg-dark
                                @elseif($sim->status == 'damaged') bg-danger
                                @elseif($sim->status == 'expired') bg-warning
                                @else bg-secondary
                                @endif
                            ">
                                {{ ucfirst($sim->status) }}
                            </span>
                            @if($sim->isExpired())
                                <i class="fas fa-clock text-danger ms-1" title="Expired"></i>
                            @endif
                        </td>
                        <td>{{ $sim->batch_id ?: 'N/A' }}</td>
                        <td>
                            <div class="d-flex align-items-center flex-wrap gap-1">
                                <a href="{{ route('sim-stocks.show', $sim->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @can('manage sim stock')
                                <a href="{{ route('sim-stocks.edit', $sim->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if($sim->status === 'available')
                                <form action="{{ route('sim-stocks.activate', $sim->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Activate" onclick="return confirm('Activate this SIM?')">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('sim-stocks.destroy', $sim->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
            
            <!-- Bulk Actions -->
            <div class="mt-3 d-none" id="bulkActions">
                <div class="card">
                    <div class="card-body">
                        <h6>Bulk Actions</h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-success" onclick="bulkAction('activate')">
                                <i class="fas fa-play"></i> Activate Selected
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" onclick="bulkAction('mark_damaged')">
                                <i class="fas fa-exclamation-triangle"></i> Mark as Damaged
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="bulkAction('mark_expired')">
                                <i class="fas fa-clock"></i> Mark as Expired
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $simStocks->withQueryString()->links('pagination::bootstrap-5') }}
            </div>

        </div>
        @else
        <div class="empty-state text-center py-5 bg-light rounded border">
            <i class="fas fa-sim-card fa-4x text-muted"></i>
            <h4 class="mt-3">No SIM Stock Found</h4>
            <p class="text-muted">Start by adding a new SIM card entry or adjust your search filters.</p>
            @can('manage sim stock')
            <a href="{{ route('sim-stocks.create') }}" class="btn btn-primary mt-2"><i class="fas fa-plus"></i> Add SIM</a>
            @endcan
        </div>
        @endif
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" action="{{ route('sim-stocks.bulk-update') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkActionType">
    <div id="bulkSimIds"></div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const simCheckboxes = document.querySelectorAll('.sim-checkbox');
    const bulkActions = document.getElementById('bulkActions');

    // Select all functionality
    selectAll.addEventListener('change', function() {
        simCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkActions();
    });

    // Individual checkbox functionality
    simCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.sim-checkbox:checked');
            selectAll.checked = checkedBoxes.length === simCheckboxes.length;
            toggleBulkActions();
        });
    });

    function toggleBulkActions() {
        const checkedBoxes = document.querySelectorAll('.sim-checkbox:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.classList.remove('d-none');
        } else {
            bulkActions.classList.add('d-none');
        }
    }
});

function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.sim-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Please select at least one SIM card.');
        return;
    }

    if (!confirm(`Are you sure you want to ${action.replace('_', ' ')} ${checkedBoxes.length} selected SIM card(s)?`)) {
        return;
    }

    const form = document.getElementById('bulkActionForm');
    const actionInput = document.getElementById('bulkActionType');
    const idsContainer = document.getElementById('bulkSimIds');

    actionInput.value = action;
    idsContainer.innerHTML = '';

    checkedBoxes.forEach(checkbox => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'sim_ids[]';
        hiddenInput.value = checkbox.value;
        idsContainer.appendChild(hiddenInput);
    });

    form.submit();
}
</script>

@endsection
