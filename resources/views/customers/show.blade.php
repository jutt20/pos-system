@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Employee Portal UI</h1>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#overview">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer-details">Customer Details</a>
        </li>
    </ul>

    <!-- Customer Details Section -->
    <div class="content-section">
        <h2 class="section-title">Customer Details</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Balance</th>
                    <th>Prepaid</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td class="{{ $customer->balance > 0 ? 'text-success' : 'text-danger' }}">
                        ${{ number_format($customer->balance, 2) }}
                    </td>
                    <td>{{ $customer->prepaid_status == 'prepaid' ? 'Yes (Advance Paid)' : 'No' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Customer SIM Purchase & Activation Overview -->
    <div class="content-section">
        <h2 class="section-title">Customer SIM Purchase & Activation Overview</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Brand</th>
                    <th>Network</th>
                    <th>SIM Type</th>
                    <th>Quantity</th>
                    <th>Shipping Status</th>
                    <th>Payment Method</th>
                    <th>Activation SKU</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer->activations as $activation)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $activation->brand }}</td>
                    <td>AT&T</td>
                    <td>Standard SIM</td>
                    <td>{{ $activation->quantity }}</td>
                    <td>
                        <span class="status-badge status-active">Delivered</span>
                    </td>
                    <td>Credit Card</td>
                    <td>{{ $activation->sku }}</td>
                </tr>
                @endforeach
                
                @if($customer->activations->isEmpty())
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>Nexitel Blue</td>
                    <td>AT&T</td>
                    <td>Standard SIM</td>
                    <td>300</td>
                    <td>
                        <span class="status-badge status-active">Delivered</span>
                    </td>
                    <td>Credit Card</td>
                    <td>SKU-BLUE-001</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
