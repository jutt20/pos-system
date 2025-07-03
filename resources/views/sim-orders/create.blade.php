@extends('layouts.app')

@section('title', 'Create SIM Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create New SIM Order</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sim-orders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vendor" class="form-label">Vendor</label>
                                <input type="text" class="form-control @error('vendor') is-invalid @enderror" 
                                       id="vendor" name="vendor" value="{{ old('vendor') }}" required>
                                @error('vendor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <select class="form-control @error('brand') is-invalid @enderror" 
                                        id="brand" name="brand" required>
                                    <option value="">Select Brand</option>
                                    <option value="Verizon" {{ old('brand') == 'Verizon' ? 'selected' : '' }}>Verizon</option>
                                    <option value="AT&T" {{ old('brand') == 'AT&T' ? 'selected' : '' }}>AT&T</option>
                                    <option value="T-Mobile" {{ old('brand') == 'T-Mobile' ? 'selected' : '' }}>T-Mobile</option>
                                    <option value="Sprint" {{ old('brand') == 'Sprint' ? 'selected' : '' }}>Sprint</option>
                                    <option value="Cricket" {{ old('brand') == 'Cricket' ? 'selected' : '' }}>Cricket</option>
                                    <option value="Metro PCS" {{ old('brand') == 'Metro PCS' ? 'selected' : '' }}>Metro PCS</option>
                                    <option value="Boost Mobile" {{ old('brand') == 'Boost Mobile' ? 'selected' : '' }}>Boost Mobile</option>
                                    <option value="Other" {{ old('brand') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sim_type" class="form-label">SIM Type</label>
                                <select class="form-control @error('sim_type') is-invalid @enderror" 
                                        id="sim_type" name="sim_type" required>
                                    <option value="">Select SIM Type</option>
                                    <option value="Nano SIM" {{ old('sim_type') == 'Nano SIM' ? 'selected' : '' }}>Nano SIM</option>
                                    <option value="Micro SIM" {{ old('sim_type') == 'Micro SIM' ? 'selected' : '' }}>Micro SIM</option>
                                    <option value="Standard SIM" {{ old('sim_type') == 'Standard SIM' ? 'selected' : '' }}>Standard SIM</option>
                                    <option value="eSIM" {{ old('sim_type') == 'eSIM' ? 'selected' : '' }}>eSIM</option>
                                    <option value="Triple Cut" {{ old('sim_type') == 'Triple Cut' ? 'selected' : '' }}>Triple Cut</option>
                                </select>
                                @error('sim_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order_date" class="form-label">Order Date</label>
                                <input type="date" class="form-control @error('order_date') is-invalid @enderror" 
                                       id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                                @error('order_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cost_per_sim" class="form-label">Cost Per SIM ($)</label>
                                <input type="number" step="0.01" class="form-control @error('cost_per_sim') is-invalid @enderror" 
                                       id="cost_per_sim" name="cost_per_sim" value="{{ old('cost_per_sim') }}" min="0" required>
                                @error('cost_per_sim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tracking_number" class="form-label">Tracking Number (Optional)</label>
                                <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" 
                                       id="tracking_number" name="tracking_number" value="{{ old('tracking_number') }}">
                                @error('tracking_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="invoice_file" class="form-label">Invoice File (Optional)</label>
                                <input type="file" class="form-control @error('invoice_file') is-invalid @enderror" 
                                       id="invoice_file" name="invoice_file" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">Accepted formats: PDF, JPG, PNG (Max: 2MB)</small>
                                @error('invoice_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <strong>Total Cost:</strong> $<span id="total_cost">0.00</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('sim-orders.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create SIM Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const costPerSimInput = document.getElementById('cost_per_sim');
    const totalCostSpan = document.getElementById('total_cost');
    
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const costPerSim = parseFloat(costPerSimInput.value) || 0;
        const total = quantity * costPerSim;
        totalCostSpan.textContent = total.toFixed(2);
    }
    
    quantityInput.addEventListener('input', calculateTotal);
    costPerSimInput.addEventListener('input', calculateTotal);
    
    // Calculate initial total
    calculateTotal();
});
</script>
@endsection
