@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">SIM Order Management</h1>
        <a href="{{ route('sim-orders.create') }}" class="btn-primary">Create Order</a>
    </div>

    <div class="content-section">
        <h2 class="section-title">All SIM Orders</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Vendor</th>
                    <th>Brand</th>
                    <th>SIM Type</th>
                    <th>Quantity</th>
                    <th>Cost per SIM</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($simOrders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->vendor }}</td>
                    <td>{{ $order->brand }}</td>
                    <td>{{ $order->sim_type }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>${{ number_format($order->cost_per_sim, 2) }}</td>
                    <td>${{ number_format($order->total_cost, 2) }}</td>
                    <td>
                        <span class="status-badge {{ $order->status == 'delivered' ? 'status-paid' : ($order->status == 'shipped' ? 'status-active' : 'status-unpaid') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->order_date->format('M d, Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('sim-orders.show', $order) }}" class="btn-sm">View</a>
                            <a href="{{ route('sim-orders.edit', $order) }}" class="btn-sm">Edit</a>
                            <form action="{{ route('sim-orders.destroy', $order) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm" style="background: #fee2e2; color: #991b1b;" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 40px;">
                        No SIM orders found. <a href="{{ route('sim-orders.create') }}">Create your first order</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $simOrders->links() }}
        </div>
    </div>
</div>
@endsection
