@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Activation Management</h1>
        <div class="header-actions">
            <a href="{{ route('activations.create') }}" class="btn-primary">Add Activation</a>
        </div>
    </div>

    <div class="content-section">
        <h2 class="section-title">All Activations</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Brand</th>
                    <th>Plan</th>
                    <th>SKU</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Cost</th>
                    <th>Profit</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activations as $activation)
                <tr>
                    <td>{{ $activation->customer->name }}</td>
                    <td>{{ $activation->brand }}</td>
                    <td>{{ $activation->plan }}</td>
                    <td>{{ $activation->sku }}</td>
                    <td>{{ $activation->quantity }}</td>
                    <td>${{ number_format($activation->price, 2) }}</td>
                    <td>${{ number_format($activation->cost, 2) }}</td>
                    <td class="{{ $activation->profit > 0 ? 'text-success' : 'text-danger' }}">
                        ${{ number_format($activation->profit, 2) }}
                    </td>
                    <td>{{ $activation->activation_date->format('M d, Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('activations.show', $activation) }}" class="btn-sm">View</a>
                            <a href="{{ route('activations.edit', $activation) }}" class="btn-sm">Edit</a>
                            <form action="{{ route('activations.destroy', $activation) }}" method="POST" style="display: inline;">
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
                        No activations found. <a href="{{ route('activations.create') }}">Add your first activation</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $activations->links() }}
        </div>
    </div>
</div>
@endsection
