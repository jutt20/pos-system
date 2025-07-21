<!DOCTYPE html>
<html>
<head>
    <title>SIM Order Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h2>Invoice for SIM Order #{{ $order->id }}</h2>
    <p>Customer: {{ $order->customer->name ?? 'N/A' }}</p>
    <p>Vendor: {{ $order->vendor }}</p>
    <p>Order Type: {{ ucfirst($order->order_type) }}</p>
    <p>Order Date: {{ $order->order_date->format('d M Y') }}</p>

    <h4>Details</h4>
    <table>
        <thead>
            <tr>
                <th>Brand</th>
                <th>SIM Type</th>
                <th>Quantity</th>
                <th>Unit Cost ($)</th>
                <th>Total ($)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->brand }}</td>
                <td>{{ $order->sim_type }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ number_format($order->unit_cost, 2) }}</td>
                <td>{{ number_format($order->total_cost, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @if($order->order_type == 'delivery')
    <h4>Delivery Information</h4>
    <p>Address: {{ $order->delivery_address }}, {{ $order->delivery_city }}, {{ $order->delivery_state }} {{ $order->delivery_zip }}</p>
    <p>Phone: {{ $order->delivery_phone }}</p>
    @endif

    <h4>Status: {{ ucfirst($order->status) }}</h4>
</body>
</html>
