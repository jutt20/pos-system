@extends('layouts.app')

@section('title', 'Admin Portal Dashboard')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Admin Portal Dashboard</h1>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Customers</div>
            <div class="stat-value">{{ $stats['total_customers'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Balance</div>
            <div class="stat-value green">${{ number_format($stats['total_revenue'], 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Invoices</div>
            <div class="stat-value">{{ $stats['pending_invoices'] }}</div>
        </div>
    </div>

    <!-- Customers Section -->
    <div class="content-section">
        <h2 class="section-title">Customers</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach(App\Models\Customer::take(5)->get() as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->company }}</td>
                    <td class="{{ $customer->balance > 0 ? 'text-success' : 'text-danger' }}">
                        ${{ number_format($customer->balance, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Products Section -->
    <div class="content-section">
        <h2 class="section-title">Products</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>SIM Card - USA</td>
                    <td>$10.99</td>
                </tr>
                <tr>
                    <td>Data Plan 10GB</td>
                    <td>$25.00</td>
                </tr>
                <tr>
                    <td>Global Roaming Pack</td>
                    <td>$50.00</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Activations Section -->
    <div class="content-section">
        <h2 class="section-title">Activations</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Plan</th>
                    <th>SKU</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentActivations as $activation)
                <tr>
                    <td>{{ $activation->customer->name }}</td>
                    <td>{{ $activation->plan }}</td>
                    <td>{{ $activation->sku }}</td>
                    <td>{{ $activation->quantity }}</td>
                    <td>${{ number_format($activation->price, 2) }}</td>
                    <td>${{ number_format($activation->price * $activation->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Invoices Section -->
    <div class="content-section">
        <h2 class="section-title">Invoices</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentInvoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>${{ number_format($invoice->total_amount, 2) }}</td>
                    <td>
                        <span class="status-badge {{ $invoice->status == 'paid' ? 'status-paid' : 'status-unpaid' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Purchase Orders Section -->
    <div class="content-section">
        <h2 class="section-title">Purchase Orders</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nexitel Blue</td>
                    <td>Standard SIM</td>
                    <td>300</td>
                    <td>2025-06-01</td>
                </tr>
                <tr>
                    <td>Nexitel Purple</td>
                    <td>eSIM</td>
                    <td>150</td>
                    <td>2025-06-03</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Revenue',
            data: [
                @foreach(range(1, 12) as $month)
                    {{ $monthlyRevenue->where('month', $month)->first()->revenue ?? 0 }},
                @endforeach
            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Brand Chart
const brandCtx = document.getElementById('brandChart').getContext('2d');
const brandChart = new Chart(brandCtx, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($activationsByBrand as $brand)
                '{{ $brand->brand }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($activationsByBrand as $brand)
                    {{ $brand->count }},
                @endforeach
            ],
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40'
            ]
        }]
    },
    options: {
        responsive: true
    }
});
</script>
@endpush
