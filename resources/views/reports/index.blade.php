@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Reports & Analytics</h1>
        <div class="header-actions">
            <a href="{{ route('reports.export') }}" class="btn-primary">Export Excel</a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Customers</div>
            <div class="stat-value">{{ $stats['total_customers'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value green">${{ number_format($stats['total_revenue'], 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Activations</div>
            <div class="stat-value blue">{{ $stats['total_activations'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Profit</div>
            <div class="stat-value green">${{ number_format($stats['total_profit'], 2) }}</div>
        </div>
    </div>

    <!-- Monthly Financial Summary -->
    <div class="content-section">
        <h2 class="section-title">Monthly Financial Summary</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Invoices</th>
                    <th>Total Billed</th>
                    <th>Revenue (Paid)</th>
                    <th>Collection Rate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyData as $data)
                <tr>
                    <td>{{ date('F Y', mktime(0, 0, 0, $data->month, 1, $data->year)) }}</td>
                    <td>{{ $data->invoices }}</td>
                    <td>${{ number_format($data->total_billed, 2) }}</td>
                    <td>${{ number_format($data->revenue, 2) }}</td>
                    <td>{{ $data->total_billed > 0 ? number_format(($data->revenue / $data->total_billed) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Top Customers -->
    <div class="content-section">
        <h2 class="section-title">Top Customers by Revenue</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Total Revenue</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topCustomers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->company ?? '-' }}</td>
                    <td>${{ number_format($customer->invoices_sum_total_amount ?? 0, 2) }}</td>
                    <td class="{{ $customer->balance > 0 ? 'text-success' : 'text-danger' }}">
                        ${{ number_format($customer->balance, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Activations by Brand -->
    <div class="content-section">
        <h2 class="section-title">Activations by Brand</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Total Activations</th>
                    <th>Total Profit</th>
                    <th>Average Profit per Activation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activationsByBrand as $brand)
                <tr>
                    <td>{{ $brand->brand }}</td>
                    <td>{{ $brand->count }}</td>
                    <td class="text-success">${{ number_format($brand->total_profit, 2) }}</td>
                    <td>${{ number_format($brand->total_profit / $brand->count, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
