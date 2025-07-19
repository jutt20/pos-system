@extends('layouts.retailer')

@section('title', 'Global Recharge')
@section('page-title', 'Global Recharge')
@section('page-subtitle', 'International mobile phone top-up services')

@section('content')
    <div class="mb-4 d-flex align-items-center">
        <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h5 class="mb-0">Account Balance: <span class="text-success fw-bold">$500.00</span></h5>
    </div>

    <div class="row g-4 mb-5">
        <!-- Mobile Recharge -->
        <div class="col-md-6">
            <div class="card text-center p-4 shadow-sm">
                <i class="fas fa-credit-card fa-2x text-success mb-3"></i>
                <h5 class="fw-bold">Mobile Recharge</h5>
                <p class="text-muted">International mobile phone top-up services worldwide</p>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="col-md-6">
            <div class="card text-center p-4 shadow-sm">
                <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                <h5 class="fw-bold">Transaction History</h5>
                <p class="text-muted">View your global recharge transaction history and reports</p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="card p-4 shadow-sm">
        <h5 class="fw-bold mb-3">Global Recharge Features</h5>
        <div class="row text-center">
            <div class="col-md-4">
                <i class="fas fa-globe fa-lg text-primary mb-2"></i>
                <h6>Worldwide Coverage</h6>
                <p class="text-muted small">Support for 6 regions and 100+ countries</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-bolt fa-lg text-success mb-2"></i>
                <h6>Instant Processing</h6>
                <p class="text-muted small">Real-time mobile top-up processing</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-file-invoice fa-lg text-purple mb-2"></i>
                <h6>Detailed Reports</h6>
                <p class="text-muted small">Complete transaction history and analytics</p>
            </div>
        </div>
    </div>
@endsection
