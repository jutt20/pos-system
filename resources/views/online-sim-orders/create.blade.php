@extends('layouts.app')

@section('title', 'Order SIM Cards Online')

@section('content')
<div class="container-fluid">
    <!-- Animated Header -->
    <div class="order-header">
        <div class="order-header-content">
            <div class="order-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="order-text">
                <h1 class="order-title">Order SIM Cards Online</h1>
                <p class="order-subtitle">Choose your preferred delivery method and place your order</p>
            </div>
        </div>
        <div class="order-steps">
            <div class="step active">
                <div class="step-number">1</div>
                <div class="step-label">Order Details</div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-label">Delivery</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>
    </div>

    <form action="{{ route('online-sim-orders.store') }}" method="POST" id="orderForm">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <!-- SIM Details Card -->
                <div class="order-card sim-details-card">
                    <div class="card-header">
                        <h3><i class="fas fa-sim-card me-2"></i>SIM Card Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand" class="form-label">Brand</label>
                                    <select class="form-select @error('brand') is-invalid @enderror" 
                                            id="brand" name="brand" required>
                                        <option value="">Select Brand</option>
                                        <option value="Verizon" {{ old('brand') == 'Verizon' ? 'selected' : '' }}>Verizon</option>
                                        <option value="AT&T" {{ old('brand') == 'AT&T' ? 'selected' : '' }}>AT&T</option>
                                        <option value="T-Mobile" {{ old('brand') == 'T-Mobile' ? 'selected' : '' }}>T-Mobile</option>
                                        <option value="Sprint" {{ old('brand') == 'Sprint' ? 'selected' : '' }}>Sprint</option>
                                        <option value="Cricket" {{ old('brand') == 'Cricket' ? 'selected' : '' }}>Cricket</option>
                                        <option value="Metro PCS" {{ old('brand') == 'Metro PCS' ? 'selected' : '' }}>Metro PCS</option>
                                        <option value="Boost Mobile" {{ old('brand') == 'Boost Mobile' ? 'selected' : '' }}>Boost Mobile</option>
                                    </select>
                                    @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sim_type" class="form-label">SIM Type</label>
                                    <select class="form-select @error('sim_type') is-invalid @enderror" 
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
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_price" class="form-label">Unit Price ($)</label>
                                    <input type="number" step="0.01" class="form-control @error('unit_price') is-invalid @enderror" 
                                           id="unit_price" name="unit_price" value="{{ old('unit_price', 25.00) }}" min="0" required>
                                    @error('unit_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Method Card -->
                <div class="order-card delivery-card">
                    <div class="card-header">
                        <h3><i class="fas fa-truck me-2"></i>Delivery Method</h3>
                    </div>
                    <div class="card-body">
                        <div class="delivery-options">
                            <div class="delivery-option">
                                <input type="radio" id="delivery" name="delivery_method" value="delivery" 
                                       {{ old('delivery_method', 'delivery') == 'delivery' ? 'checked' : '' }}>
                                <label for="delivery" class="delivery-option-label">
                                    <div class="delivery-icon">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="delivery-content">
                                        <h4>Home Delivery</h4>
                                        <p>Get your SIM cards delivered to your doorstep</p>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="delivery-option">
                                <input type="radio" id="pickup" name="delivery_method" value="pickup"
                                       {{ old('delivery_method') == 'pickup' ? 'checked' : '' }}>
                                <label for="pickup" class="delivery-option-label">
                                    <div class="delivery-icon">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div class="delivery-content">
                                        <h4>Retailer Pickup</h4>
                                        <p>Pick up from your preferred retailer location</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Delivery Address Fields -->
                        <div id="deliveryFields" class="delivery-fields">
                            <h5 class="mt-4 mb-3">Delivery Address</h5>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="delivery_address" class="form-label">Street Address</label>
                                        <input type="text" class="form-control @error('delivery_address') is-invalid @enderror" 
                                               id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}">
                                        @error('delivery_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_city" class="form-label">City</label>
                                        <input type="text" class="form-control @error('delivery_city') is-invalid @enderror" 
                                               id="delivery_city" name="delivery_city" value="{{ old('delivery_city') }}">
                                        @error('delivery_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_state" class="form-label">State</label>
                                        <input type="text" class="form-control @error('delivery_state') is-invalid @enderror" 
                                               id="delivery_state" name="delivery_state" value="{{ old('delivery_state') }}">
                                        @error('delivery_state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_zip" class="form-label">ZIP Code</label>
                                        <input type="text" class="form-control @error('delivery_zip') is-invalid @enderror" 
                                               id="delivery_zip" name="delivery_zip" value="{{ old('delivery_zip') }}">
                                        @error('delivery_zip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delivery_phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control @error('delivery_phone') is-invalid @enderror" 
                                               id="delivery_phone" name="delivery_phone" value="{{ old('delivery_phone') }}">
                                        @error('delivery_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delivery_service" class="form-label">Delivery Service</label>
                                        <select class="form-select @error('delivery_service') is-invalid @enderror" 
                                                id="delivery_service" name="delivery_service">
                                            <option value="">Select Delivery Service</option>
                                            @foreach($deliveryServices as $service)
                                            <option value="{{ $service->id }}" 
                                                    data-cost="{{ $service->base_cost }}"
                                                    data-per-item="{{ $service->per_item_cost }}"
                                                    data-days="{{ $service->estimated_days }}"
                                                    {{ old('delivery_service') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }} - ${{ $service->base_cost }} + ${{ $service->per_item_cost }}/item
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('delivery_service')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pickup Retailer Fields -->
                        <div id="pickupFields" class="pickup-fields" style="display: none;">
                            <h5 class="mt-4 mb-3">Select Retailer</h5>
                            <div class="form-group">
                                <label for="pickup_retailer_id" class="form-label">Retailer Location</label>
                                <select class="form-select @error('pickup_retailer_id') is-invalid @enderror" 
                                        id="pickup_retailer_id" name="pickup_retailer_id">
                                    <option value="">Select Retailer</option>
                                    @foreach($retailers as $retailer)
                                    <option value="{{ $retailer->id }}" {{ old('pickup_retailer_id') == $retailer->id ? 'selected' : '' }}>
                                        {{ $retailer->name }} - {{ $retailer->email }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('pickup_retailer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Notes -->
                <div class="order-card notes-card">
                    <div class="card-header">
                        <h3><i class="fas fa-comment me-2"></i>Additional Notes</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="customer_notes" class="form-label">Special Instructions (Optional)</label>
                            <textarea class="form-control @error('customer_notes') is-invalid @enderror" 
                                      id="customer_notes" name="customer_notes" rows="3" 
                                      placeholder="Any special delivery instructions or notes...">{{ old('customer_notes') }}</textarea>
                            @error('customer_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <div class="summary-header">
                        <h3><i class="fas fa-receipt me-2"></i>Order Summary</h3>
                    </div>
                    
                    <div class="summary-body">
                        <div class="summary-item">
                            <span class="item-label">Brand:</span>
                            <span class="item-value" id="summary-brand">-</span>
                        </div>
                        
                        <div class="summary-item">
                            <span class="item-label">SIM Type:</span>
                            <span class="item-value" id="summary-sim-type">-</span>
                        </div>
                        
                        <div class="summary-item">
                            <span class="item-label">Quantity:</span>
                            <span class="item-value" id="summary-quantity">1</span>
                        </div>
                        
                        <div class="summary-item">
                            <span class="item-label">Unit Price:</span>
                            <span class="item-value" id="summary-unit-price">$25.00</span>
                        </div>
                        
                        <div class="summary-divider"></div>
                        
                        <div class="summary-item">
                            <span class="item-label">Subtotal:</span>
                            <span class="item-value" id="summary-subtotal">$25.00</span>
                        </div>
                        
                        <div class="summary-item">
                            <span class="item-label">Delivery Cost:</span>
                            <span class="item-value" id="summary-delivery">$0.00</span>
                        </div>
                        
                        <div class="summary-divider"></div>
                        
                        <div class="summary-item total">
                            <span class="item-label">Total:</span>
                            <span class="item-value" id="summary-total">$25.00</span>
                        </div>
                        
                        <div class="delivery-info" id="delivery-info" style="display: none;">
                            <div class="info-item">
                                <i class="fas fa-clock me-2"></i>
                                <span>Estimated delivery: <span id="estimated-days">3-5</span> business days</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-footer">
                        <button type="submit" class="btn-place-order">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.order-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.order-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.order-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
}

.order-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0;
}

.order-steps {
    display: flex;
    gap: 2rem;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    transition: all 0.3s ease;
}

.step.active .step-number {
    background: white;
    color: #667eea;
    transform: scale(1.1);
}

.step-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

.step.active .step-label {
    opacity: 1;
    font-weight: 600;
}

.order-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.order-card .card-header {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.order-card .card-header h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
}

.order-card .card-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.delivery-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.delivery-option {
    position: relative;
}

.delivery-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.delivery-option-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.delivery-option input[type="radio"]:checked + .delivery-option-label {
    border-color: #667eea;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.delivery-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #6b7280;
    transition: all 0.3s ease;
}

.delivery-option input[type="radio"]:checked + .delivery-option-label .delivery-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.delivery-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.delivery-content p {
    margin: 0;
    opacity: 0.8;
    font-size: 0.9rem;
}

.delivery-fields, .pickup-fields {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.order-summary {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 2rem;
}

.summary-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 1.5rem 2rem;
    border-radius: 20px 20px 0 0;
}

.summary-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
}

.summary-body {
    padding: 2rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.summary-item.total {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2d3748;
}

.item-label {
    color: #6b7280;
    font-weight: 500;
}

.item-value {
    font-weight: 600;
    color: #374151;
}

.summary-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 1.5rem 0;
}

.delivery-info {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1.5rem;
}

.info-item {
    display: flex;
    align-items: center;
    color: #0369a1;
    font-size: 0.9rem;
}

.summary-footer {
    padding: 0 2rem 2rem;
}

.btn-place-order {
    width: 100%;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-place-order:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
}

@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        text-align: center;
        gap: 2rem;
    }
    
    .order-steps {
        justify-content: center;
    }
    
    .delivery-options {
        grid-template-columns: 1fr;
    }
    
    .order-title {
        font-size: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryRadio = document.getElementById('delivery');
    const pickupRadio = document.getElementById('pickup');
    const deliveryFields = document.getElementById('deliveryFields');
    const pickupFields = document.getElementById('pickupFields');
    const deliveryInfo = document.getElementById('delivery-info');
    
    // Form elements for calculations
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const brandSelect = document.getElementById('brand');
    const simTypeSelect = document.getElementById('sim_type');
    const deliveryServiceSelect = document.getElementById('delivery_service');
    
    // Summary elements
    const summaryBrand = document.getElementById('summary-brand');
    const summarySimType = document.getElementById('summary-sim-type');
    const summaryQuantity = document.getElementById('summary-quantity');
    const summaryUnitPrice = document.getElementById('summary-unit-price');
    const summarySubtotal = document.getElementById('summary-subtotal');
    const summaryDelivery = document.getElementById('summary-delivery');
    const summaryTotal = document.getElementById('summary-total');
    const estimatedDays = document.getElementById('estimated-days');
    
    // Toggle delivery/pickup fields
    function toggleDeliveryMethod() {
        if (deliveryRadio.checked) {
            deliveryFields.style.display = 'block';
            pickupFields.style.display = 'none';
            deliveryInfo.style.display = 'block';
            updateDeliveryCost();
        } else {
            deliveryFields.style.display = 'none';
            pickupFields.style.display = 'block';
            deliveryInfo.style.display = 'none';
            summaryDelivery.textContent = '$0.00';
            updateTotal();
        }
    }
    
    // Update delivery cost
    function updateDeliveryCost() {
        if (!deliveryRadio.checked) {
            summaryDelivery.textContent = '$0.00';
            updateTotal();
            return;
        }
        
        const selectedService = deliveryServiceSelect.options[deliveryServiceSelect.selectedIndex];
        if (selectedService.value) {
            const baseCost = parseFloat(selectedService.dataset.cost) || 0;
            const perItemCost = parseFloat(selectedService.dataset.perItem) || 0;
            const quantity = parseInt(quantityInput.value) || 1;
            const days = selectedService.dataset.days || '3-5';
            
            const totalDeliveryCost = baseCost + (perItemCost * quantity);
            summaryDelivery.textContent = '$' + totalDeliveryCost.toFixed(2);
            estimatedDays.textContent = days;
        } else {
            summaryDelivery.textContent = '$0.00';
        }
        updateTotal();
    }
    
    // Update summary
    function updateSummary() {
        const brand = brandSelect.value || '-';
        const simType = simTypeSelect.value || '-';
        const quantity = parseInt(quantityInput.value) || 1;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const subtotal = quantity * unitPrice;
        
        summaryBrand.textContent = brand;
        summarySimType.textContent = simType;
        summaryQuantity.textContent = quantity;
        summaryUnitPrice.textContent = '$' + unitPrice.toFixed(2);
        summarySubtotal.textContent = '$' + subtotal.toFixed(2);
        
        updateDeliveryCost();
    }
    
    // Update total
    function updateTotal() {
        const subtotal = parseFloat(summarySubtotal.textContent.replace('$', '')) || 0;
        const deliveryCost = parseFloat(summaryDelivery.textContent.replace('$', '')) || 0;
        const total = subtotal + deliveryCost;
        
        summaryTotal.textContent = '$' + total.toFixed(2);
    }
    
    // Event listeners
    deliveryRadio.addEventListener('change', toggleDeliveryMethod);
    pickupRadio.addEventListener('change', toggleDeliveryMethod);
    quantityInput.addEventListener('input', updateSummary);
    unitPriceInput.addEventListener('input', updateSummary);
    brandSelect.addEventListener('change', updateSummary);
    simTypeSelect.addEventListener('change', updateSummary);
    deliveryServiceSelect.addEventListener('change', updateDeliveryCost);
    
    // Initialize
    toggleDeliveryMethod();
    updateSummary();
    
    // Animate step progress
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;
    
    function updateSteps() {
        steps.forEach((step, index) => {
            if (index <= currentStep) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
    }
    
    // Form validation and step progression
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        currentStep = 2;
        updateSteps();
    });
});
</script>
@endsection
