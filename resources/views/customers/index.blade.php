@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Employee Portal UI</h1>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('employees.index') }}">Employee Management</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('customers.index') }}">Customer Management</a>
        </li>
    </ul>

    <!-- Customer Management Section -->
    <div class="content-section">
        <h2 class="section-title">Customer Management</h2>
        
        <!-- Add Customer Button -->
        <div style="margin-bottom: 20px;">
            <a href="{{ route('customers.create') }}" class="btn-primary">Add Customer</a>
        </div>

        <!-- Customer Details Table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Balance</th>
                    <th>Prepaid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td class="{{ $customer->balance > 0 ? 'text-success' : 'text-danger' }}">
                        ${{ number_format($customer->balance, 2) }}
                    </td>
                    <td>{{ $customer->prepaid_status == 'prepaid' ? 'Yes (Advance Paid)' : 'No' }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('customers.show', $customer) }}" class="btn-sm">View</a>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn-sm">Edit</a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm" style="background: #fee2e2; color: #991b1b;" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
