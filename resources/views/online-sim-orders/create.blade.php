@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <h1 class="page-title">
                        <i class="fas fa-plus-circle me-2"></i>
                        Create Online SIM Order
                    </h1>
                    <p class="page-subtitle">Process a new online SIM card order</p>
                </div>
                <div class="page-actions">
                    <a href="{{ route('online-sim-orders.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card modern-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Order Details
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('online-sim-orders.store') }}" method="POST" id="orderForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_id" class="form-label">Customer *</label>
                                    <select name="customer_id" id="customer_id" class="form-select" required>
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} - {{ $customer->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand" class="form-label">Brand *</label>
                                    <select name="brand" id="brand" class="form-select" required>
                                        <option value="">Select Brand</option>
                                        @foreach($simTypes->unique('brand') as $sim)
                                            <option value="{{ $sim->brand }}" {{ old('brand') == $sim->brand ? 'selected' : '' }}>
                                                {{ $sim->brand }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sim_type" class="form-label">SIM Type *</label>
                                    <select name="sim_type" id="sim_type" class="form-select" required>
                                        <option value="">Select SIM Type</option>
                                    </select>
                                    @error('sim_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">Quantity *</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" 
                                           value="{{ old('quantity', 1) }}" min="1" max="10" required>
                                    @error('quantity')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="unit_price" class="form-label">Unit Price *</label>
                                    <input type="number" name="unit_price" id="unit_price" class="form-control" 
                                           value="{{ old('unit_price', '25.00') }}" step="0.01" min="0" required>
                                    @error('unit_price')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="delivery-section">
                            <h6 class="section-title">
                                <i class="fas fa-truck me-2"></i>
                                Delivery Options
                            </h6>
                            
                            <div class="delivery-options">
                                <div class="form-check delivery-option">
                                    <input class="form-check-input" type="radio" name="delivery_option" id="pickup" value="pickup" 
                                           {{ old('delivery_option', 'pickup') == 'pickup' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pickup">
                                        <div class="option-content">
                                            <i class="fas fa-store"></i>
                                            <div>
                                                <strong>Pickup from Store</strong>
                                                <small>Customer picks up from retailer location</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="form-check delivery-option">
                                    <input class="form-check-input" type="radio" name="delivery_option" id="delivery" value="delivery"
                                           {{ old('delivery_option') == 'delivery' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="delivery">
                                        <div class="option-content">
                                            <i class="fas fa-shipping-fast"></i>
                                            <div>
                                                <strong>Home Delivery</strong>
                                                <small>Delivered to customer address</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="delivery-details" class="delivery-details" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delivery_service_id" class="form-label">Delivery Service</label>
                                        <select name="delivery_service_id" id="delivery_service_id" class="form-select">
                                            <option value="">Select Delivery Service</option>
                                            @foreach($deliveryServices as $service)
                                                <option value="{{ $service->id }}" 
                                                        data-base-cost="{{ $service->base_cost }}"
                                                        data-per-item-cost="{{ $service->per_item_cost }}"
                                                        data-estimated-days="{{ $service->estimated_days }}"
                                                        {{ old('delivery_service_id') == $service->id ? 'selected' : '' }}>
                                                    {{ $service->name }} - ${{ $service->base_cost }} + ${{ $service->per_item_cost }}/item
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delivery_phone" class="form-label">Delivery Phone</label>
                                        <input type="text" name="delivery_phone" id="delivery_phone" class="form-control" 
                                               value="{{ old('delivery_phone') }}" placeholder="Phone number for delivery">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="delivery_address" class="form-label">Delivery Address</label>
                                <textarea name="delivery_address" id="delivery_address" class="form-control" rows="2" 
                                          placeholder="Street address">{{ old('delivery_address') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_city" class="form-label">City</label>
                                        <input type="text" name="delivery_city" id="delivery_city" class="form-control" 
                                               value="{{ old('delivery_city') }}" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_state" class="form-label">State</label>
                                        <input type="text" name="delivery_state" id="delivery_state" class="form-control" 
                                               value="{{ old('delivery_state') }}" placeholder="State">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_zip" class="form-label">ZIP Code</label>
                                        <input type="text" name="delivery_zip" id="delivery_zip" class="form-control" 
                                               value="{{ old('delivery_zip') }}" placeholder="ZIP Code">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label">Order Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" 
                                      placeholder="Any special instructions or notes">{{ old('notes') }}</textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Create Order
                            </button>
                            <a href="{{ route('online-sim-orders.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card modern-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calculator me-2"></i>
                        Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="order-summary">
                        <div class="summary-row">
                            <span>Quantity:</span>
                            <span id="summary-quantity">1</span>
                        </div>
                        <div class="summary-row">
                            <span>Unit Price:</span>
                            <span id="summary-unit-price">$25.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="summary-subtotal">$25.00</span>
                        </div>
                        <div class="summary-row" id="delivery-cost-row" style="display: none;">
                            <span>Delivery Cost:</span>
                            <span id="summary-delivery-cost">$0.00</span>
                        </div>
                        <div class="summary-row total">
                            <span><strong>Total:</strong></span>
                            <span id="summary-total"><strong>$25.00</strong></span>
                        </div>
                        <div class="estimated-delivery" id="estimated-delivery" style="display: none;">
                            <i class="fas fa-clock me-2"></i>
                            <span>Estimated delivery: <span id="delivery-date"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card modern-card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Order Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Orders require admin approval</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-truck text-primary"></i>
                            <span>Multiple delivery options available</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-search text-info"></i>
                            <span>Real-time order tracking</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone text-warning"></i>
                            <span>Customer support available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.page-subtitle {
    opacity: 0.9;
    margin: 0;
    font-size: 1.1rem;
}

.modern-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.modern-card:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 16px 16px 0 0 !important;
    padding: 1.5rem;
}

.card-title {
    color: #2d3748;
    font-weight: 600;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.section-title {
    color: #2d3748;
    font-weight: 600;
    font-size: 1.1rem;
    margin: 2rem 0 1rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e2e8f0;
}

.delivery-options {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.delivery-option {
    flex: 1;
    margin: 0;
}

.delivery-option .form-check-label {
    width: 100%;
    padding: 1.5rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.delivery-option .form-check-input:checked + .form-check-label {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
}

.option-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.option-content i {
    font-size: 1.5rem;
    color: #667eea;
}

.delivery-details {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
    margin-top: 1rem;
    border: 2px solid #e2e8f0;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #e2e8f0;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 1.1rem;
    border-radius: 12px;
}

.order-summary {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e2e8f0;
}

.summary-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.summary-row.total {
    border-top: 2px solid #667eea;
    padding-top: 0.75rem;
    margin-top: 0.75rem;
    font-size: 1.1rem;
}

.estimated-delivery {
    background: rgba(102, 126, 234, 0.1);
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
    color: #667eea;
    font-weight: 500;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.95rem;
}

.info-item i {
    width: 20px;
    text-align: center;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .delivery-options {
        flex-direction: column;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandSelect = document.getElementById('brand');
    const simTypeSelect = document.getElementById('sim_type');
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const deliveryOptions = document.querySelectorAll('input[name="delivery_option"]');
    const deliveryDetails = document.getElementById('delivery-details');
    const deliveryServiceSelect = document.getElementById('delivery_service_id');
    
    const simTypes = @json($simTypes);
    
    // Update SIM types based on brand selection
    brandSelect.addEventListener('change', function() {
        const selectedBrand = this.value;
        simTypeSelect.innerHTML = '<option value="">Select SIM Type</option>';
        
        if (selectedBrand) {
            const filteredTypes = simTypes.filter(sim => sim.brand === selectedBrand);
            filteredTypes.forEach(sim => {
                const option = document.createElement('option');
                option.value = sim.sim_type;
                option.textContent = sim.sim_type;
                simTypeSelect.appendChild(option);
            });
        }
    });
    
    // Show/hide delivery details
    deliveryOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'delivery') {
                deliveryDetails.style.display = 'block';
                document.getElementById('delivery-cost-row').style.display = 'flex';
            } else {
                deliveryDetails.style.display = 'none';
                document.getElementById('delivery-cost-row').style.display = 'none';
            }
            updateSummary();
        });
    });
    
    // Update summary when values change
    [quantityInput, unitPriceInput, deliveryServiceSelect].forEach(element => {
        element.addEventListener('input', updateSummary);
        element.addEventListener('change', updateSummary);
    });
    
    function updateSummary() {
        const quantity = parseInt(quantityInput.value) || 1;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const subtotal = quantity * unitPrice;
        
        document.getElementById('summary-quantity').textContent = quantity;
        document.getElementById('summary-unit-price').textContent = '$' + unitPrice.toFixed(2);
        document.getElementById('summary-subtotal').textContent = '$' + subtotal.toFixed(2);
        
        let deliveryCost = 0;
        const deliveryOption = document.querySelector('input[name="delivery_option"]:checked');
        
        if (deliveryOption && deliveryOption.value === 'delivery') {
            const selectedService = deliveryServiceSelect.selectedOptions[0];
            if (selectedService) {
                const baseCost = parseFloat(selectedService.dataset.baseCost) || 0;
                const perItemCost = parseFloat(selectedService.dataset.perItemCost) || 0;
                const estimatedDays = parseInt(selectedService.dataset.estimatedDays) || 0;
                
                deliveryCost = baseCost + (perItemCost * quantity);
                document.getElementById('summary-delivery-cost').textContent = '$' + deliveryCost.toFixed(2);
                
                if (estimatedDays > 0) {
                    const deliveryDate = new Date();
                    deliveryDate.setDate(deliveryDate.getDate() + estimatedDays);
                    document.getElementById('delivery-date').textContent = deliveryDate.toLocaleDateString();
                    document.getElementById('estimated-delivery').style.display = 'block';
                } else {
                    document.getElementById('estimated-delivery').style.display = 'none';
                }
            }
        } else {
            document.getElementById('estimated-delivery').style.display = 'none';
        }
        
        const total = subtotal + deliveryCost;
        document.getElementById('summary-total').innerHTML = '<strong>$' + total.toFixed(2) + '</strong>';
    }
    
    // Initialize summary
    updateSummary();
    
    // Initialize delivery details visibility
    const checkedOption = document.querySelector('input[name="delivery_option"]:checked');
    if (checkedOption && checkedOption.value === 'delivery') {
        deliveryDetails.style.display = 'block';
        document.getElementById('delivery-cost-row').style.display = 'flex';
    }
});
</script>
@endsection
