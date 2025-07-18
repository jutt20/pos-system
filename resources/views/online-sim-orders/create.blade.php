<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order SIM Cards - Nexitel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .order-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 20px auto;
            max-width: 800px;
        }
        .order-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin: 30px 0;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            position: relative;
        }
        .step.active {
            background: #667eea;
            color: white;
        }
        .step.completed {
            background: #28a745;
            color: white;
        }
        .step::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 20px;
            height: 2px;
            background: #e9ecef;
            transform: translateY(-50%);
        }
        .step:last-child::after {
            display: none;
        }
        .form-section {
            padding: 30px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
        }
        .delivery-option {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .delivery-option:hover {
            border-color: #667eea;
        }
        .delivery-option.selected {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }
        .cost-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="order-container">
            <div class="order-header">
                <h1><i class="fas fa-sim-card"></i> Order SIM Cards</h1>
                <p>Get your Nexitel SIM cards delivered to your door</p>
            </div>

            <div class="step-indicator">
                <div class="step active" id="step1">1</div>
                <div class="step" id="step2">2</div>
                <div class="step" id="step3">3</div>
                <div class="step" id="step4">4</div>
            </div>

            <form action="{{ route('sim-order.store') }}" method="POST" id="orderForm">
                @csrf
                
                <!-- Step 1: Customer Information -->
                <div class="form-section" id="section1">
                    <h3><i class="fas fa-user"></i> Customer Information</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="customer_email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" name="customer_phone" class="form-control" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next <i class="fas fa-arrow-right"></i></button>
                </div>

                <!-- Step 2: SIM Selection -->
                <div class="form-section d-none" id="section2">
                    <h3><i class="fas fa-sim-card"></i> SIM Card Selection</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand *</label>
                            <select name="brand" class="form-control" required onchange="updatePricing()">
                                <option value="">Select Brand</option>
                                <option value="Nexitel Purple">Nexitel Purple</option>
                                <option value="Nexitel Blue">Nexitel Blue</option>
                                <option value="Generic">Generic</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SIM Type *</label>
                            <select name="sim_type" class="form-control" required onchange="updatePricing()">
                                <option value="">Select Type</option>
                                <option value="Physical">Physical SIM</option>
                                <option value="eSIM">eSIM</option>
                                <option value="Dual">Physical + eSIM</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity *</label>
                            <input type="number" name="quantity" class="form-control" min="1" max="10" value="1" required onchange="updatePricing()">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(1)"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Step 3: Delivery Options -->
                <div class="form-section d-none" id="section3">
                    <h3><i class="fas fa-truck"></i> Delivery Options</h3>
                    
                    <div class="delivery-option" onclick="selectDeliveryOption('pickup')">
                        <input type="radio" name="delivery_option" value="pickup" id="pickup" style="display: none;">
                        <h5><i class="fas fa-store"></i> Store Pickup</h5>
                        <p>Pick up from our store location - FREE</p>
                    </div>

                    <div class="delivery-option" onclick="selectDeliveryOption('delivery')">
                        <input type="radio" name="delivery_option" value="delivery" id="delivery" style="display: none;">
                        <h5><i class="fas fa-shipping-fast"></i> Home Delivery</h5>
                        <p>Get it delivered to your address</p>
                    </div>

                    <div id="deliveryServices" class="d-none mt-3">
                        <label class="form-label">Select Delivery Service</label>
                        <select name="delivery_service_id" class="form-control" onchange="updatePricing()">
                            <option value="">Choose delivery service</option>
                            @foreach($deliveryServices as $service)
                            <option value="{{ $service->id }}" data-cost="{{ $service->base_cost }}" data-per-item="{{ $service->per_item_cost }}">
                                {{ $service->name }} - ${{ $service->base_cost }} ({{ $service->estimated_days }} days)
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="deliveryAddress" class="d-none mt-3">
                        <h5>Delivery Address</h5>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Street Address</label>
                                <input type="text" name="delivery_address" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="delivery_city" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="delivery_state" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" name="delivery_zip" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Delivery Phone</label>
                                <input type="tel" name="delivery_phone" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(2)"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(4)">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Step 4: Review & Submit -->
                <div class="form-section d-none" id="section4">
                    <h3><i class="fas fa-check-circle"></i> Review Your Order</h3>
                    
                    <div class="cost-summary">
                        <h5>Order Summary</h5>
                        <div class="d-flex justify-content-between">
                            <span>SIM Cards:</span>
                            <span id="simCost">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Delivery:</span>
                            <span id="deliveryCost">$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong id="totalCost">$0.00</strong>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Any special instructions..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(3)"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-shopping-cart"></i> Place Order
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 1;
        const baseSimPrice = 25.00;

        function nextStep(step) {
            if (validateCurrentStep()) {
                document.getElementById(`section${currentStep}`).classList.add('d-none');
                document.getElementById(`step${currentStep}`).classList.remove('active');
                document.getElementById(`step${currentStep}`).classList.add('completed');
                
                currentStep = step;
                document.getElementById(`section${currentStep}`).classList.remove('d-none');
                document.getElementById(`step${currentStep}`).classList.add('active');
                
                if (step === 4) {
                    updateOrderSummary();
                }
            }
        }

        function prevStep(step) {
            document.getElementById(`section${currentStep}`).classList.add('d-none');
            document.getElementById(`step${currentStep}`).classList.remove('active');
            
            currentStep = step;
            document.getElementById(`section${currentStep}`).classList.remove('d-none');
            document.getElementById(`step${currentStep}`).classList.add('active');
            document.getElementById(`step${currentStep}`).classList.remove('completed');
        }

        function validateCurrentStep() {
            const section = document.getElementById(`section${currentStep}`);
            const requiredFields = section.querySelectorAll('[required]');
            
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    field.focus();
                    alert('Please fill in all required fields.');
                    return false;
                }
            }
            return true;
        }

        function selectDeliveryOption(option) {
            document.querySelectorAll('.delivery-option').forEach(el => el.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            document.getElementById(option).checked = true;
            
            if (option === 'delivery') {
                document.getElementById('deliveryServices').classList.remove('d-none');
                document.getElementById('deliveryAddress').classList.remove('d-none');
            } else {
                document.getElementById('deliveryServices').classList.add('d-none');
                document.getElementById('deliveryAddress').classList.add('d-none');
            }
            updatePricing();
        }

        function updatePricing() {
            const quantity = parseInt(document.querySelector('[name="quantity"]').value) || 1;
            const simCost = baseSimPrice * quantity;
            
            let deliveryCost = 0;
            const deliveryOption = document.querySelector('[name="delivery_option"]:checked');
            
            if (deliveryOption && deliveryOption.value === 'delivery') {
                const serviceSelect = document.querySelector('[name="delivery_service_id"]');
                if (serviceSelect.value) {
                    const option = serviceSelect.selectedOptions[0];
                    const baseCost = parseFloat(option.dataset.cost) || 0;
                    const perItemCost = parseFloat(option.dataset.perItem) || 0;
                    deliveryCost = baseCost + (perItemCost * quantity);
                }
            }
            
            document.getElementById('simCost').textContent = `$${simCost.toFixed(2)}`;
            document.getElementById('deliveryCost').textContent = `$${deliveryCost.toFixed(2)}`;
            document.getElementById('totalCost').textContent = `$${(simCost + deliveryCost).toFixed(2)}`;
        }

        function updateOrderSummary() {
            updatePricing();
        }

        // Initialize
        updatePricing();
    </script>
</body>
</html>
