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

    <!-- Admin Portal - Nexitel Overview -->
    <div class="content-section">
        <h2 class="section-title">Admin Portal - Nexitel Overview</h2>
        
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Activations</div>
                <div class="stat-value blue">140</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value green">$2300.00</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Profit</div>
                <div class="stat-value green">$1100.00</div>
            </div>
        </div>
    </div>

    <!-- Activations by SKU & Brand -->
    <div class="content-section">
        <h2 class="section-title">Activations by SKU & Brand</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Plan</th>
                    <th>SKU</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Selling Price</th>
                    <th>Vendor Cost</th>
                    <th>Total</th>
                    <th>Profit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nexitel Blue</td>
                    <td>Unlimited Talk</td>
                    <td>SKU-BLUE-001</td>
                    <td>John Doe</td>
                    <td>100</td>
                    <td>$15.00</td>
                    <td>$10.00</td>
                    <td>$1500.00</td>
                    <td>$500.00</td>
                </tr>
                <tr>
                    <td>Nexitel Purple</td>
                    <td>Premium Plan</td>
                    <td>SKU-PURPLE-002</td>
                    <td>Jane Smith</td>
                    <td>40</td>
                    <td>$20.00</td>
                    <td>$15.00</td>
                    <td>$800.00</td>
                    <td>$200.00</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- SIM Purchase Orders by Network -->
    <div class="content-section">
        <h2 class="section-title">SIM Purchase Orders by Network</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Network</th>
                    <th>SIM Type</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nexitel Blue</td>
                    <td>AT&T</td>
                    <td>Standard SIM</td>
                    <td>John Doe</td>
                    <td>300</td>
                    <td>2025-06-01</td>
                </tr>
                <tr>
                    <td>Nexitel Purple</td>
                    <td>T-Mobile</td>
                    <td>eSIM</td>
                    <td>Jane Smith</td>
                    <td>150</td>
                    <td>2025-06-03</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
