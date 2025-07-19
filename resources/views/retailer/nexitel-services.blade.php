@extends('layouts.retailer') 

@section('title', 'Nexitel Activation')
@section('page-title', 'Nexitel Activation')
@section('page-subtitle', 'Complete wireless service management')

@section('content')
    <div class="mb-4">
        <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="services-grid">
        <!-- Card 1 -->
        <a href="{{ route('retailer.nexitel.activation') }}" class="text-decoration-none">
            <div class="service-card">
                <div class="service-icon purple"><i class="fas fa-user-plus"></i></div>
                <div class="service-title">New Activation</div>
                <div class="service-description">Activate new Nexitel services for customers</div>
            </div>
        </a>

        <!-- Card 2 -->
        <a href="{{ route('retailer.nexitel.recharge') }}" class="text-decoration-none">
            <div class="service-card">
                <div class="service-icon green"><i class="fas fa-wallet"></i></div>
                <div class="service-title">Recharge</div>
                <div class="service-description">Top-up Nexitel Purple and Blue services</div>
            </div>
        </a>

        <!-- Card 3 -->
        <a href="{{ route('retailer.nexitel.recharge.report') }}" class="text-decoration-none">
            <div class="service-card">
                <div class="service-icon purple"><i class="fas fa-file-invoice-dollar"></i></div>
                <div class="service-title">Recharge Report</div>
                <div class="service-description">View recharge transaction history and analytics</div>
            </div>
        </a>

        <!-- Card 4 -->
        <a href="{{ route('retailer.nexitel.activation.report') }}" class="text-decoration-none">
            <div class="service-card">
                <div class="service-icon purple"><i class="fas fa-clipboard-list"></i></div>
                <div class="service-title">Activation Report</div>
                <div class="service-description">Track activation records and customer data</div>
            </div>
        </a>

        <!-- Card 5 -->
        <a href="{{ route('retailer.nexitel.sim.swap') }}" class="text-decoration-none">
            <div class="service-card">
                <div class="service-icon orange"><i class="fas fa-sim-card"></i></div>
                <div class="service-title">SIM Swap</div>
                <div class="service-description">Replace damaged or lost SIM cards</div>
            </div>
        </a>

        <!-- Card 6 -->
        <a href="{{ route('retailer.nexitel.port.status') }}" class="text-decoration-none">
            <div class="service-card">
                <div class="service-icon green"><i class="fas fa-random"></i></div>
                <div class="service-title">Port-In Status</div>
                <div class="service-description">Track number porting requests and progress</div>
            </div>
        </a>

        <!-- Card 7 -->
        <a href="{{ route('retailer.nexitel.bulk.activation') }}" class="text-decoration-none">
            <div class="service-card">
                <div class="service-icon purple"><i class="fas fa-upload"></i></div>
                <div class="service-title">Bulk Activation</div>
                <div class="service-description">Upload CSV file for batch SIM activations</div>
            </div>
        </a>

        <!-- Card 8 -->
        <a href="{{ route('retailer.nexitel.wifi.enable') }}" class="text-decoration-none">
            <div class="service-card">
                <div class="service-icon green"><i class="fas fa-wifi"></i></div>
                <div class="service-title">WiFi Enable Upload</div>
                <div class="service-description">Enable WiFi services via CSV file upload</div>
            </div>
        </a>
    </div>
@endsection
