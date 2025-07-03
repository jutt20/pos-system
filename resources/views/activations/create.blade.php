@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Add New Activation</h1>
    </div>

    <div class="content-section">
        <form action="{{ route('activations.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="customer_id" class="form-label">Customer *</label>
                    <select id="customer_id" name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="activation_date" class="form-label">Activation Date *</label>
                    <input type="date" id="activation_date" name="activation_date" class="form-control" value="{{ old('activation_date', date('Y-m-d')) }}" required>
                    @error('activation_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="brand" class="form-label">Brand *</label>
                    <select id="brand" name="brand" class="form-control" required>
                        <option value="">Select Brand</option>
                        <option value="Nexitel Blue" {{ old('brand') == 'Nexitel Blue' ? 'selected' : '' }}>Nexitel Blue</option>
                        <option value="Nexitel Purple" {{ old('brand') == 'Nexitel Purple' ? 'selected' : '' }}>Nexitel Purple</option>
                        <option value="AT&T" {{ old('brand') == 'AT&T' ? 'selected' : '' }}>AT&T</option>
                        <option value="T-Mobile" {{ old('brand') == 'T-Mobile' ? 'selected' : '' }}>T-Mobile</option>
                        <option value="Verizon" {{ old('brand') == 'Verizon' ? 'selected' : '' }}>Verizon</option>
                    </select>
                    @error('brand')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="plan" class="form-label">Plan *</label>
                    <input type="text" id="plan" name="plan" class="form-control" value="{{ old('plan') }}" placeholder="e.g., Unlimited Talk, Premium Plan" required>
                    @error('plan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sku" class="form-label">SKU *</label>
                    <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku') }}" placeholder="e.g., SKU-BLUE-001" required>
                    @error('sku')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="quantity" class="form-label">Quantity *</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
                    @error('quantity')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Selling Price *</label>
                    <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price') }}" min="0" required>
                    @error('price')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cost" class="form-label">Cost Price *</label>
                    <input type="number" step="0.01" id="cost" name="cost" class="form-control" value="{{ old('cost') }}" min="0" required>
                    @error('cost')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Estimated Profit</label>
                    <input type="text" id="profit-display" class="form-control" readonly placeholder="$0.00">
                </div>
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Notes</label>
                <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-primary">Create Activation</button>
                <a href="{{ route('activations.index') }}" class="btn-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function calculateProfit() {
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const price = parseFloat(document.getElementById('price').value) || 0;
    const cost = parseFloat(document.getElementById('cost').value) || 0;
    
    const profit = (price - cost) * quantity;
    document.getElementById('profit-display').value = '$' + profit.toFixed(2);
}

document.getElementById('quantity').addEventListener('input', calculateProfit);
document.getElementById('price').addEventListener('input', calculateProfit);
document.getElementById('cost').addEventListener('input', calculateProfit);
</script>
@endsection
