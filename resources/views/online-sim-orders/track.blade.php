@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="tracking-header">
                <div class="tracking-info">
                    <h1 class="tracking-title">
                        <i class="fas fa-search me-2"></i>
                        Order Tracking
                    </h1>
                    <p class="tracking-subtitle">Track your SIM card order in real-time</p>
                </div>
                <div class="order-number">
                    <span class="order-label">Order #</span>
                    <span class="order-value">{{ $order->order_number }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card tracking-card">
                        <div class="card-body">
                            <div class="tracking-progress">
                                <div class="progress-timeline">
                                    <div class="timeline-item {{ $order->status == 'pending' ? 'active' : ($order->status != 'cancelled' ? 'completed' : '') }}">
                                        <div class="timeline-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6>Order Placed</h6>
                                            <p>Your order has been received and is pending approval</p>
                                            <small>{{ $order->created_at->format('M d, Y - h:i A') }}</small>
                                        </div>
                                    </div>

                                    <div class="timeline-item {{ $order->status == 'approved' ? 'active' : (in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : '') }}">
                                        <div class="timeline-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6>Order Approved</h6>
                                            <p>Your order has been approved and is being prepared</p>
                                            @if($order->approved_at)
                                                <small>{{ $order->approved_at->format('M d, Y - h:i A') }}</small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="timeline-item {{ $order->status == 'processing' ? 'active' : (in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '') }}">
                                        <div class="timeline-icon">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6>Processing</h6>
                                            <p>Your SIM cards are being prepared for {{ $order->delivery_option == 'pickup' ? 'pickup' : 'shipment' }}</p>
                                        </div>
                                    </div>

                                    @if($order->delivery_option == 'delivery')
                                    <div class="timeline-item {{ $order->status == 'shipped' ? 'active' : ($order->status == 'delivered' ? 'completed' : '') }}">
                                        <div class="timeline-icon">
                                            <i class="fas fa-shipping-fast"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6>Shipped</h6>
                                            <p>Your order is on its way to your delivery address</p>
                                            @if($order->tracking_number)
                                                <div class="tracking-number-display">
                                                    <strong>Tracking #: {{ $order->tracking_number }}</strong>
                                                    @if($order->tracking_url)
                                                        <a href="{{ $order->tracking_url }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                            <i class="fas fa-external-link-alt"></i> Track with Carrier
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif

                                    <div class="timeline-item {{ $order->status == 'delivered' ? 'active completed' : '' }}">
                                        <div class="timeline-icon">
                                            <i class="fas fa-check-double"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6>{{ $order->delivery_option == 'pickup' ? 'Ready for Pickup' : 'Delivered' }}</h6>
                                            <p>{{ $order->delivery_option == 'pickup' ? 'Your order is ready for pickup at our store' : 'Your order has been successfully delivered' }}</p>
                                        </div>
                                    </div>

                                    @if($order->status == 'cancelled')
                                    <div class="timeline-item cancelled">
                                        <div class="timeline-icon">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6>Order Cancelled</h6>
                                            <p>This order has been cancelled</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if($order->estimated_delivery && $order->status != 'delivered')
                            <div class="estimated-delivery-info">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <strong>Estimated {{ $order->delivery_option == 'pickup' ? 'Ready Date' : 'Delivery' }}: </strong>
                                {{ $order->estimated_delivery->format('M d, Y') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card order-details-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Order Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="detail-group">
                                <label>Customer:</label>
                                <span>{{ $order->customer->name }}</span>
                            </div>
                            <div class="detail-group">
                                <label>Email:</label>
                                <span>{{ $order->customer->email }}</span>
                            </div>
                            <div class="detail-group">
                                <label>Phone:</label>
                                <span>{{ $order->customer->phone }}</span>
                            </div>
                            <div class="detail-group">
                                <label>SIM Brand:</label>
                                <span>{{ $order->brand }}</span>
                            </div>
                            <div class="detail-group">
                                <label>SIM Type:</label>
                                <span>{{ $order->sim_type }}</span>
                            </div>
                            <div class="detail-group">
                                <label>Quantity:</label>
                                <span>{{ $order->quantity }}</span>
                            </div>
                            <div class="detail-group">
                                <label>Unit Price:</label>
                                <span>${{ number_format($order->unit_price, 2) }}</span>
                            </div>
                            @if($order->delivery_cost > 0)
                            <div class="detail-group">
                                <label>Delivery Cost:</label>
                                <span>${{ number_format($order->delivery_cost, 2) }}</span>
                            </div>
                            @endif
                            <div class="detail-group total">
                                <label><strong>Total Amount:</strong></label>
                                <span><strong>${{ number_format($order->total_amount, 2) }}</strong></span>
                            </div>
                        </div>
                    </div>

                    @if($order->delivery_option == 'delivery')
                    <div class="card delivery-info-card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-truck me-2"></i>
                                Delivery Information
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($order->deliveryService)
                            <div class="detail-group">
                                <label>Delivery Service:</label>
                                <span>{{ $order->deliveryService->name }}</span>
                            </div>
                            @endif
                            <div class="detail-group">
                                <label>Delivery Address:</label>
                                <div class="address">
                                    {{ $order->delivery_address }}<br>
                                    {{ $order->delivery_city }}, {{ $order->delivery_state }} {{ $order->delivery_zip }}
                                </div>
                            </div>
                            <div class="detail-group">
                                <label>Delivery Phone:</label>
                                <span>{{ $order->delivery_phone }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($order->notes)
                    <div class="card notes-card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-sticky-note me-2"></i>
                                Order Notes
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tracking-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.tracking-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 30px 30px;
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.tracking-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.tracking-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0;
}

.order-number {
    text-align: right;
    position: relative;
    z-index: 2;
}

.order-label {
    display: block;
    font-size: 0.9rem;
    opacity: 0.8;
    margin-bottom: 0.5rem;
}

.order-value {
    font-size: 1.8rem;
    font-weight: 700;
    background: rgba(255,255,255,0.2);
    padding: 0.5rem 1rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.tracking-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.progress-timeline {
    position: relative;
    padding: 2rem 0;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 3rem;
    position: relative;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.timeline-item.active,
.timeline-item.completed {
    opacity: 1;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 25px;
    top: 50px;
    width: 2px;
    height: calc(100% + 1rem);
    background: #e2e8f0;
    z-index: 1;
}

.timeline-item.completed:not(:last-child)::after {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.timeline-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.5rem;
    position: relative;
    z-index: 2;
    transition: all 0.3s ease;
}

.timeline-item.active .timeline-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    animation: pulse 2s infinite;
}

.timeline-item.completed .timeline-icon {
    background: linear-gradient(135deg, #48bb78, #38a169);
    color: white;
}

.timeline-item.cancelled .timeline-icon {
    background: linear-gradient(135deg, #f56565, #e53e3e);
    color: white;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(102, 126, 234, 0); }
    100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
}

.timeline-content {
    flex: 1;
    padding-top: 0.5rem;
}

.timeline-content h6 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.timeline-content p {
    color: #718096;
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

.timeline-content small {
    color: #a0aec0;
    font-size: 0.85rem;
}

.tracking-number-display {
    background: rgba(102, 126, 234, 0.1);
    padding: 1rem;
    border-radius: 8px;
    margin-top: 0.5rem;
    border-left: 4px solid #667eea;
}

.estimated-delivery-info {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    padding: 1.5rem;
    border-radius: 12px;
    margin-top: 2rem;
    color: #667eea;
    font-size: 1.1rem;
    text-align: center;
}

.order-details-card,
.delivery-info-card,
.notes-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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

.detail-group {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.detail-group:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.detail-group.total {
    border-top: 2px solid #667eea;
    padding-top: 1rem;
    margin-top: 1rem;
    font-size: 1.1rem;
}

.detail-group label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0;
    flex-shrink: 0;
    margin-right: 1rem;
}

.detail-group span {
    color: #2d3748;
    text-align: right;
    flex: 1;
}

.address {
    text-align: right;
    line-height: 1.4;
}

@media (max-width: 768px) {
    .tracking-header {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .tracking-title {
        font-size: 2rem;
    }
    
    .order-number {
        text-align: center;
    }
    
    .timeline-item {
        margin-bottom: 2rem;
    }
    
    .timeline-icon {
        width: 40px;
        height: 40px;
        margin-right: 1rem;
    }
    
    .detail-group {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .detail-group span,
    .address {
        text-align: left;
    }
}
</style>
@endsection
