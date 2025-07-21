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
                <form action="{{ route('sim-orders.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Customer</label>
                            <select name="customer_id" class="form-control" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vendor</label>
                            <input type="text" name="vendor" class="form-control" required value="{{ old('vendor') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand</label>
                            <input type="text" name="brand" class="form-control" required value="{{ old('brand') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">SIM Type</label>
                            <select name="sim_type" class="form-control" required>
                                <option value="">Select SIM Type</option>
                                <option value="Nano SIM">Nano SIM</option>
                                <option value="Micro SIM">Micro SIM</option>
                                <option value="Standard SIM">Standard SIM</option>
                                <option value="eSIM">eSIM</option>
                                <option value="Triple Cut">Triple Cut</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Order Type</label>
                            <select name="order_type" id="order_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="pickup">Pickup</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" min="1" class="form-control" required id="quantity" value="{{ old('quantity') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cost Per SIM ($)</label>
                            <input type="number" name="unit_cost" min="0" step="0.01" class="form-control" required id="unit_cost" value="{{ old('unit_cost') }}">
                        </div>
                    </div>

                    <div id="delivery-fields" style="display:none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Delivery Service</label>
                                <select name="delivery_service_id" class="form-control">
                                    <option value="">Select Delivery Service</option>
                                    @foreach($deliveryServices as $service)
                                        <option value="{{ $service->id }}" {{ old('delivery_service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Delivery Address</label>
                                <input type="text" name="delivery_address" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Delivery City</label>
                                <input type="text" name="delivery_city" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Delivery State</label>
                                <input type="text" name="delivery_state" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Delivery ZIP</label>
                                <input type="text" name="delivery_zip" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Delivery Phone</label>
                                <input type="text" name="delivery_phone" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Delivery Cost ($)</label>
                                <input type="number" step="0.01" name="delivery_cost" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tracking Number (Optional)</label>
                            <input type="text" name="tracking_number" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Order Date</label>
                            <input type="date" name="order_date" class="form-control" value="{{ old('order_date', date('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <div class="alert alert-info">
                            <strong>Total Cost:</strong> $<span id="total_cost">0.00</span>
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
    const unitCostInput = document.getElementById('unit_cost');
    const totalCostSpan = document.getElementById('total_cost');
    const orderTypeSelect = document.getElementById('order_type');
    const deliveryFields = document.getElementById('delivery-fields');

    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitCost = parseFloat(unitCostInput.value) || 0;
        const total = quantity * unitCost;
        totalCostSpan.textContent = total.toFixed(2);
    }

    quantityInput.addEventListener('input', calculateTotal);
    unitCostInput.addEventListener('input', calculateTotal);
    calculateTotal();

    orderTypeSelect.addEventListener('change', function() {
        deliveryFields.style.display = this.value === 'delivery' ? 'block' : 'none';
    });
});
</script>
@endsection
