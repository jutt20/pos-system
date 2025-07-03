@extends('layouts.app')

@section('content')
<div class="main-container">
    <h1 class="welcome-header">Welcome, John Doe</h1>

    <!-- Account Summary -->
    <div class="content-section">
        <h2 class="section-title">Account Summary</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <strong>Email:</strong> john@example.com
            </div>
            <div>
                <strong>Phone:</strong> +1 555 123 4567
            </div>
            <div>
                <strong>Balance:</strong> <span class="text-success">$250.00</span>
            </div>
            <div>
                <strong>Prepaid:</strong> Yes (Advance Paid)
            </div>
        </div>
    </div>

    <!-- Your Activations -->
    <div class="content-section">
        <h2 class="section-title">Your Activations</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Plan</th>
                    <th>SKU</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Unlimited Talk</td>
                    <td>SKU-BLUE-001</td>
                    <td>Nexitel Blue</td>
                    <td>100</td>
                    <td><span class="status-badge status-active">Active</span></td>
                </tr>
                <tr>
                    <td>Premium Plan</td>
                    <td>SKU-PURPLE-002</td>
                    <td>Nexitel Purple</td>
                    <td>40</td>
                    <td><span class="status-badge status-unpaid">Pending</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Your SIM Purchases -->
    <div class="content-section">
        <h2 class="section-title">Your SIM Purchases</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Network</th>
                    <th>SIM Type</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Shipping Status</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nexitel Blue</td>
                    <td>AT&T</td>
                    <td>Standard SIM</td>
                    <td>300</td>
                    <td>2025-06-01</td>
                    <td><span class="status-badge status-paid">Delivered</span></td>
                    <td>Credit Card</td>
                </tr>
                <tr>
                    <td>Nexitel Purple</td>
                    <td>T-Mobile</td>
                    <td>eSIM</td>
                    <td>150</td>
                    <td>2025-06-03</td>
                    <td><span class="status-badge status-unpaid">In Transit</span></td>
                    <td>Bank Transfer</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
