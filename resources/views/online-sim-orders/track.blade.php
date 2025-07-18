<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order {{ $order->order_number }} - Nexitel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .tracking-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 20px auto;
            max-width: 900px;
        }
        .tracking-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .status-timeline {
            padding: 40px;
        }
        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }
        .timeline-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            position: relative;
            z-index: 2;
        }
        .timeline-icon.completed {
            background: #28a745;
            color: white;
        }
        .timeline-icon.current {
            background: #007bff;
            color: white;
            animation: pulse 2s infinite;
        }
        .timeline-icon.pending {
            background: #e9ecef;
            color: #6c757d;
        }
        .timeline-content {
            flex: 1;
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            left: 25px;
            top: 50px;
            width: 2px;
            height: 30px;
            background: #e9ecef;
        }
        .timeline-item:last-child::after {
            display: none;
        }
        .timeline-item.completed::after {
            background: #28a745;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(0, 123, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 123, 255, 0); }
        }
        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .tracking-number {
            background: #e3f2fd;
            border: 2px dashed #2196f3;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tracking-container">
            <div class="tracking-header">
                <h1><i class="fas fa-search"></i> Order Tracking</h1>
                <h3>{{ $order->order_number }}</h3>
                <p>Track your SIM card order status</p>
            </div>

            <div class="status-timeline">
                <div class="order-details">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-user"></i> Customer Information</h5>
                            <p><strong>Name:</strong> {{ $order->customer->name }}</p>
                            <p><strong>Email:</strong> {{ $order->customer->email }}</p>
                            <p><strong>Phone:</strong> {{ $order->customer->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-sim-card"></i> Order Details</h5>
                            <p><strong>Brand:</strong> {{ $order->brand }}</p>
                            <p><strong>Type:</strong> {{ $order->sim_type }}</p>
                            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                            <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                @if($order->tracking_number)
                <div class="tracking-number">
                    <h5><i class="fas fa-barcode"></i> Tracking Number</h5>
                    <h3>{{ $order->tracking_number }}</h3>
                    @if($order->getTrackingUrl())
                    <a href="{{ $order->getTrackingUrl() }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-external-link-alt"></i> Track with {{ $order->deliveryService->name }}
                    </a>
                    @endif
                </div>
                @endif

                <h4><i class="fas fa-timeline"></i> Order Status Timeline</h4>

                <div class="timeline-item {{ $order->status === 'pending' ? 'current' : 'completed' }}">
                    <div class="timeline-icon {{ $order->status === 'pending' ? 'current' : 'completed' }}">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="timeline-content">
                        <h5>Order Placed</h5>
                        <p>Your order has been received and is awaiting approval.</p>
                        <small class="text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</small>
                    </div>
                </div>

                <div class="timeline-item {{ in_array($order->status, ['approved', 'processing', 'shipped', 'delivered']) ? ($order->status === 'approved' ? 'current' : 'completed') : 'pending' }}">
                    <div class="timeline-icon {{ in_array($order->status, ['approved', 'processing', 'shipped', 'delivered']) ? ($order->status === 'approved' ? 'current' : 'completed') : 'pending' }}">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="timeline-content">
                        <h5>Order Approved</h5>
                        <p>Your order has been approved and will be processed soon.</p>
                        @if($order->approved_at)
                        <small class="text-muted">{{ $order->approved_at->format('M d, Y h:i A') }}</small>
                        @endif
                    </div>
                </div>

                <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? ($order->status === 'processing' ? 'current' : 'completed') : 'pending' }}">
                    <div class="timeline-icon {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? ($order->status === 'processing' ? 'current' : 'completed') : 'pending' }}">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="timeline-content">
                        <h5>Processing</h5>
                        <p>Your SIM cards are being prepared for shipment.</p>
                    </div>
                </div>

                @if($order->delivery_option === 'delivery')
                <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? ($order->status === 'shipped' ? 'current' : 'completed') : 'pending' }}">
                    <div class="timeline-icon {{ in_array($order->status, ['shipped', 'delivered']) ? ($order->status === 'shipped' ? 'current' : 'completed') : 'pending' }}">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="timeline-content">
                        <h5>Shipped</h5>
                        <p>Your order is on its way via {{ $order->deliveryService->name ?? 'delivery service' }}.</p>
                        @if($order->estimated_delivery)
                        <p><strong>Estimated Delivery:</strong> {{ $order->estimated_delivery->format('M d, Y') }}</p>
                        @endif
                    </div>
                </div>

                <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : 'pending' }}">
                    <div class="timeline-icon {{ $order->status === 'delivered' ? 'completed' : 'pending' }}">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="timeline-content">
                        <h5>Delivered</h5>
                        <p>Your SIM cards have been delivered to your address.</p>
                    </div>
                </div>
                @else
                <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : 'pending' }}">
                    <div class="timeline-icon {{ $order->status === 'delivered' ? 'completed' : 'pending' }}">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="timeline-content">
                        <h5>Ready for Pickup</h5>
                        <p>Your SIM cards are ready for pickup at our store.</p>
                    </div>
                </div>
                @endif

                @if($order->status === 'cancelled')
                <div class="alert alert-danger mt-4">
                    <h5><i class="fas fa-times-circle"></i> Order Cancelled</h5>
                    <p>This order has been cancelled. If you have any questions, please contact our support team.</p>
                </div>
                @endif

                @if($order->admin_notes)
                <div class="alert alert-info mt-4">
                    <h5><i class="fas fa-info-circle"></i> Additional Information</h5>
                    <p>{{ $order->admin_notes }}</p>
                </div>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('welcome') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                    <a href="{{ route('sim-order.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Place New Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh page every 30 seconds for live updates
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
