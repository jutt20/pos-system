@extends('layouts.app')

@section('title', 'Create SIM Stock')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle"></i> Create New SIM Stock
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sim-stocks.store') }}" method="POST">
                    @csrf

                    <!-- Category Selection -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-tags"></i> SIM Category
                            </h6>
                            <div class="row">
                                @foreach($categories as $key => $category)
                                <div class="col-md-4 mb-3">
                                    <div class="form-check category-card">
                                        <input class="form-check-input" type="radio" name="category" 
                                               id="category_{{ $key }}" value="{{ $key }}" 
                                               {{ old('category') == $key ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="category_{{ $key }}">
                                            <div class="card h-100 border-2" style="border-color: {{ $category['color'] }};">
                                                <div class="card-body text-center">
                                                    <div class="category-color mb-2" 
                                                         style="width: 30px; height: 30px; background-color: {{ $category['color'] }}; 
                                                                border-radius: 50%; margin: 0 auto;"></div>
                                                    <h6 class="card-title">{{ $category['name'] }}</h6>
                                                    <p class="card-text small text-muted">{{ $category['description'] }}</p>
                                                    <span class="badge" style="background-color: {{ $category['color'] }};">
                                                        {{ $category['type'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('category') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-info-circle"></i> Basic Information
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sim_number" class="form-label">SIM Number</label>
                                <input type="text" class="form-control @error('sim_number') is-invalid @enderror"
                                    id="sim_number" name="sim_number" value="{{ old('sim_number') }}" 
                                    placeholder="Enter SIM number (optional)">
                                @error('sim_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="iccid" class="form-label">ICCID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('iccid') is-invalid @enderror"
                                    id="iccid" name="iccid" value="{{ old('iccid') }}" 
                                    placeholder="Enter ICCID" required>
                                @error('iccid') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="serial_number" class="form-label">Serial Number</label>
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                    id="serial_number" name="serial_number" value="{{ old('serial_number') }}" 
                                    placeholder="Enter serial number">
                                @error('serial_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sim_type" class="form-label">SIM Type <span class="text-danger">*</span></label>
                                <select class="form-control @error('sim_type') is-invalid @enderror"
                                    id="sim_type" name="sim_type" required>
                                    <option value="">Select SIM Type</option>
                                    @foreach(['Nano SIM', 'Micro SIM', 'Standard SIM', 'eSIM', 'Triple Cut'] as $type)
                                        <option value="{{ $type }}" {{ old('sim_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('sim_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Vendor & Brand Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-building"></i> Vendor & Brand Information
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vendor" class="form-label">Vendor</label>
                                <input type="text" class="form-control @error('vendor') is-invalid @enderror"
                                    id="vendor" name="vendor" value="{{ old('vendor') }}" 
                                    placeholder="Enter Vendor Name">
                                @error('vendor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <select class="form-control @error('brand') is-invalid @enderror"
                                    id="brand" name="brand">
                                    <option value="">Select Brand</option>
                                    @foreach(['Nexitel', 'Verizon', 'AT&T', 'T-Mobile', 'Sprint', 'Cricket', 'Metro PCS', 'Boost Mobile', 'Other'] as $brand)
                                        <option value="{{ $brand }}" {{ old('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                                @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="network_provider" class="form-label">Network Provider</label>
                                <input type="text" class="form-control @error('network_provider') is-invalid @enderror"
                                    id="network_provider" name="network_provider" value="{{ old('network_provider') }}" 
                                    placeholder="Enter Network Provider">
                                @error('network_provider') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="plan_type" class="form-label">Plan Type</label>
                                <input type="text" class="form-control @error('plan_type') is-invalid @enderror"
                                    id="plan_type" name="plan_type" value="{{ old('plan_type') }}" 
                                    placeholder="Enter Plan Type">
                                @error('plan_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-dollar-sign"></i> Pricing & Stock Information
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cost" class="form-label">Cost ($) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror"
                                    id="cost" name="cost" value="{{ old('cost') }}" min="0" 
                                    placeholder="Enter Cost" required>
                                @error('cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="monthly_cost" class="form-label">Monthly Cost ($)</label>
                                <input type="number" step="0.01" class="form-control @error('monthly_cost') is-invalid @enderror"
                                    id="monthly_cost" name="monthly_cost" value="{{ old('monthly_cost') }}" min="0" 
                                    placeholder="Enter Monthly Cost">
                                @error('monthly_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    @foreach(['available', 'used', 'reserved', 'sold', 'damaged', 'expired'] as $status)
                                        <option value="{{ $status }}" {{ old('status', 'available') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock_level" class="form-label">Stock Level <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_level') is-invalid @enderror"
                                    id="stock_level" name="stock_level" value="{{ old('stock_level', 1) }}" min="0" required>
                                @error('stock_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="minimum_stock" class="form-label">Minimum Stock <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('minimum_stock') is-invalid @enderror"
                                    id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', 10) }}" min="0" required>
                                @error('minimum_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security Codes -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-lock"></i> Security Codes
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="pin1" class="form-label">PIN 1</label>
                                <input type="text" class="form-control @error('pin1') is-invalid @enderror"
                                    id="pin1" name="pin1" value="{{ old('pin1') }}" placeholder="Enter PIN 1">
                                @error('pin1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="puk1" class="form-label">PUK 1</label>
                                <input type="text" class="form-control @error('puk1') is-invalid @enderror"
                                    id="puk1" name="puk1" value="{{ old('puk1') }}" placeholder="Enter PUK 1">
                                @error('puk1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="pin2" class="form-label">PIN 2</label>
                                <input type="text" class="form-control @error('pin2') is-invalid @enderror"
                                    id="pin2" name="pin2" value="{{ old('pin2') }}" placeholder="Enter PIN 2">
                                @error('pin2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="puk2" class="form-label">PUK 2</label>
                                <input type="text" class="form-control @error('puk2') is-invalid @enderror"
                                    id="puk2" name="puk2" value="{{ old('puk2') }}" placeholder="Enter PUK 2">
                                @error('puk2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-cogs"></i> Additional Information
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qr_activation_code" class="form-label">QR Activation Code</label>
                                <textarea class="form-control @error('qr_activation_code') is-invalid @enderror"
                                    id="qr_activation_code" name="qr_activation_code" rows="3" 
                                    placeholder="Enter QR Activation Code">{{ old('qr_activation_code') }}</textarea>
                                @error('qr_activation_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="batch_id" class="form-label">Batch ID</label>
                                        <input type="text" class="form-control @error('batch_id') is-invalid @enderror"
                                            id="batch_id" name="batch_id" value="{{ old('batch_id') }}" 
                                            placeholder="Enter Batch ID">
                                        @error('batch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                                            id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                                        @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-map-marker-alt"></i> Location Information
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="warehouse_location" class="form-label">Warehouse Location</label>
                                <input type="text" class="form-control @error('warehouse_location') is-invalid @enderror"
                                    id="warehouse_location" name="warehouse_location" value="{{ old('warehouse_location') }}" 
                                    placeholder="Enter Warehouse Location">
                                @error('warehouse_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="shelf_position" class="form-label">Shelf Position</label>
                                <input type="text" class="form-control @error('shelf_position') is-invalid @enderror"
                                    id="shelf_position" name="shelf_position" value="{{ old('shelf_position') }}" 
                                    placeholder="Enter Shelf Position">
                                @error('shelf_position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('sim-stocks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create SIM Stock
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
.category-card .form-check-input:checked + .form-check-label .card {
    border-width: 3px !important;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.category-card .form-check-input {
    display: none;
}

.category-card .form-check-label {
    cursor: pointer;
}

.category-card .card {
    transition: all 0.3s ease;
}

.category-card .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection
