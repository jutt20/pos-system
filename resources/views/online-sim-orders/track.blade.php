@extends('layouts.app')

@section('title', 'Track Order - ' . $order->order_number)

@section('content')
<div class="container-fluid">
    <!-- Order Tracking Header -->
    <div class="tracking-header">
        <div class="tracking-header-content">
            <div class="tracking-icon">
                <i class="{{ $order->status_icon }}"></i>
            </div>
            <div class="tracking-info">
                <h1 class="tracking-title">Order {{ $order->order_number }}</h1>
                <p class="tracking-subtitle">Track your SIM card order status and delivery</p>
            </div>
        </div>
        <div class="tracking-status">
            <span class="status-badge status-{{ $order->status_color }}">
                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </span>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Progress -->
            <div class="progress-card">
                <div class="progress-header">
                    <h3><i class="fas fa-route me-2"></i>Order Progress</h3>
                </div>
                <div class="progress-body">
                    <div class="progress-timeline">
                        <div class="timeline-item {{ in_array($order->status, ['pending', 'approved', 'processing', 'shipped', 'delivered', 'ready_for_pickup']) ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Order Placed</h4>
                                <p>{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item {{ in_array($order->status, ['approved', 'processing', 'shipped', 'delivered', 'ready_for_pickup']) ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Order Approved</h4>
                                <p>{{ $order->approved_at ? $order->approved_at->format('M d, Y h:i A') : 'Pending approval' }}</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered', 'ready_for_pickup']) ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Processing</h4>
                                <p>{{ $order->processed_at ? $order->processed_at->format('M d, Y h:i A') : 'Not started' }}</p>
                            </div>
                        </div>
                        
                        @if($order->delivery_method === 'delivery')
                        <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Shipped</h4>
                                <p>{{ $order->shipped_at ? $order->shipped_at->format('M d, Y h:i A') : 'Not shipped yet' }}</p>
                                @if($order->tracking_number)
                                <div class="tracking-number">
                                    <strong>Tracking: {{ $order->tracking_number }}</strong>
                                    @if($order->tracking_url)
                                    <a href="{{ $order->tracking_url }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                        <i class="fas fa-external-link-alt"></i> Track Package
                                    </a>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Delivered</h4>
                                <p>{{ $order->delivered_at ? $order->delivered_at->format('M d, Y h:i A') : 'Not delivered yet' }}</p>
                                @if($order->estimated_delivery_date && !$order->delivered_at)
                                <small class="text-muted">Estimated: {{ $order->estimated_delivery_date->format('M d, Y') }}</small>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="timeline-item {{ $order->status === 'ready_for_pickup' ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Ready for Pickup</h4>
                                <p>{{ $order->status === 'ready_for_pickup' ? 'Ready now' : 'Not ready yet' }}</p>
                                @if($order->pickupRetailer)
                                <div class="retailer-info">
                                    <strong>Pickup Location:</strong><br>
                                    {{ $order->pickupRetailer->name }}<br>
                                    {{ $order->pickupRetailer->email }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="details-card">
                <div class="details-header">
                    <h3><i class="fas fa-info-circle me-2"></i>Order Details</h3>
                </div>
                <div class="details-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label>Brand</label>
                                <div class="detail-value">{{ $order->brand }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label>SIM Type</label>
                                <div class="detail-value">{{ $order->sim_type }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label>Quantity</label>
                                <div class="detail-value">{{ $order->quantity }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label>Unit Price</label>
                                <div class="detail-value">${{ number_format($order->unit_price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($order->delivery_method === 'delivery')
                    <div class="delivery-details">
                        <h5 class="mt-4 mb-3">Delivery Information</h5>
                        <div class="delivery-address">
                            <strong>Address:</strong><br>
                            {{ $order->delivery_address }}<br>
                            {{ $order->delivery_city }}, {{ $order->delivery_state }} {{ $order->delivery_zip }}<br>
                            <strong>Phone:</strong> {{ $order->delivery_phone }}
                        </div>
                    </div>
                    @endif
                    
                    @if($order->customer_notes)
                    <div class="notes-section">
                        <h5 class="mt-4 mb-3">Customer Notes</h5>
                        <div class="notes-content">{{ $order->customer_notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="summary-card">
                <div class="summary-header">
                    <h3><i class="fas fa-receipt me-2"></i>Order Summary</h3>
                </div>
                <div class="summary-body">
                    <div class="summary-item">
                        <span class="item-label">Subtotal:</span>
                        <span class="item-value">${{ number_format($order->unit_price * $order->quantity, 2) }}</span>
                    </div>
                    
                    @if($order->delivery_cost > 0)
                    <div class="summary-item">
                        <span class="item-label">Delivery:</span>
                        <span class="item-value">${{ number_format($order->delivery_cost, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-item total">
                        <span class="item-label">Total:</span>
                        <span class="item-value">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="support-card">
                <div class="support-header">
                    <h3><i class="fas fa-headset me-2"></i>Need Help?</h3>
                </div>
                <div class="support-body">
                    <p>If you have any questions about your order, please contact our support team.</p>
                    <div class="support-actions">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Call Support
                        </a>
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="fas fa-envelope me-2"></i>Email Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tracking-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tracking-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.tracking-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    animation: trackingPulse 2s infinite;
}

@keyframes trackingPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.tracking-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
}

.tracking-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0;
}

.tracking-status {
    text-align: right;
}

.status-badge {
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending { background: #fbbf24; color: #92400e; }
.status-info { background: #60a5fa; color: #1e40af; }
.status-primary { background: #8b5cf6; color: #5b21b6; }
.status-success { background: #34d399; color: #065f46; }
.status-warning { background: #fbbf24; color: #92400e; }
.status-danger { background: #f87171; color: #991b1b; }

.progress-card, .details-card, .summary-card, .support-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    overflow: hidden;
}

.progress-header, .details-header, .summary-header, .support-header {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.progress-header h3, .details-header h3, .summary-header h3, .support-header h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
}

.progress-body, .details-body, .summary-body, .support-body {
    padding: 2rem;
}

.progress-timeline {
    position: relative;
}

.progress-timeline::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e7eb;
}

.timeline-item {
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding-left: 1rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #9ca3af;
    position: relative;
    z-index: 2;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.timeline-item.completed .timeline-icon {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
}

.timeline-content h4 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.timeline-content p {
    color: #6b7280;
    margin: 0;
    font-size: 0.9rem;
}

.tracking-number {
    margin-top: 0.5rem;
    padding: 0.75rem;
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 8px;
    font-size: 0.9rem;
}

.retailer-info {
    margin-top: 0.5rem;
    padding: 0.75rem;
    background: #fef3c7;
    border: 1px solid #fcd34d;
    border-radius: 8px;
    font-size: 0.9rem;
}

.detail-group {
    margin-bottom: 1.5rem;
}

.detail-group label {
    display: block;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
}

.delivery-details, .notes-section {
    border-top: 1px solid #e5e7eb;
    padding-top: 1.5rem;
}

.delivery-address, .notes-content {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    color: #374151;
    line-height: 1.6;
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
    border-top: 2px solid #e5e7eb;
    padding-top: 1rem;
    margin-top: 1rem;
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

.support-body p {
    color: #6b7280;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.support-actions {
    display: flex;
    gap: 1rem;
}

.support-actions .btn {
    flex: 1;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
}

.support-actions .btn:hover {
    transform: translateY(-2px);
    text-decoration: none;
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
    
    .timeline-item {
        flex-direction: column;
        text-align: center;
    }
    
    .progress-timeline::before {
        display: none;
    }
    
    .support-actions {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh tracking page every 30 seconds
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            location.reload();
        }
    }, 30000);
    
    // Animate timeline items on load
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.6s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>
@endsection
