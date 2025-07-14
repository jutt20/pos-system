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
                <i class="fas fa-shopping-cart"></i>
                SIM Stock Management
            </h1>
            <p class="page-subtitle">Manage and track all SIM card purchases</p>
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

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Stock</div>
                <div class="stat-value blue">{{ $simStocks->total() }}</div>
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
                <div class="stat-label">Available Stock</div>
                <div class="stat-value green">{{ $availableCount }}</div>
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
                <div class="stat-label">Sold Out</div>
                <div class="stat-value">{{ $soldCount }}</div>
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
                <div class="stat-value">${{ number_format($simStocks->sum('cost'), 2) }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +15% from last month
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <form method="GET" action="{{ route('sim-stocks.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search SIM Number or ICCID" value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used</option>
                <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
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
                <i class="fas fa-sim-card"></i> SIM Stock List
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
                        <th>ID</th>
                        <th>SIM Number</th>
                        <th>ICCID</th>
                        <th>Brand</th>
                        <th>Type</th>
                        <th>Cost</th>
                        <th>Status</th>
                        <th>Vendor</th>
                        <th>Batch ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($simStocks as $sim)
                    <tr>
                        <td>{{ $sim->id }}</td>
                        <td>{{ $sim->sim_number }}</td>
                        <td>{{ $sim->iccid }}</td>
                        <td>{{ $sim->brand }}</td>
                        <td>{{ $sim->sim_type }}</td>
                        <td>${{ number_format($sim->cost, 2) }}</td>
                        <td>
                            <span class="badge
                                @if($sim->status == 'available') bg-success
                                @elseif($sim->status == 'used') bg-warning
                                @elseif($sim->status == 'reserved') bg-info
                                @elseif($sim->status == 'sold') bg-danger
                                @else bg-secondary
                                @endif
                            ">
                                {{ ucfirst($sim->status) }}
                            </span>
                        </td>

                        <td>{{ $sim->vendor }}</td>
                        <td>{{ $sim->batch_id }}</td>
                        <td>
                            <div class="d-flex align-items-center flex-wrap gap-1">
                                <a href="{{ route('sim-stocks.show', $sim->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @can('manage sim stock')
                                <a href="{{ route('sim-stocks.edit', $sim->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

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
            <div class="mt-4">
                {{ $simStocks->withQueryString()->links('pagination::bootstrap-5') }}
            </div>

        </div>
        @else
        <div class="empty-state text-center py-5 bg-light rounded border">
            <i class="fas fa-sim-card fa-4x text-muted"></i>
            <h4 class="mt-3">No SIM Stock Found</h4>
            <p class="text-muted">Start by adding a new SIM card entry.</p>
            @can('manage sim stock')
            <a href="{{ route('sim-stocks.create') }}" class="btn btn-primary mt-2"><i class="fas fa-plus"></i> Add SIM</a>
            @endcan
        </div>
        @endif
    </div>
</div>

@endsection