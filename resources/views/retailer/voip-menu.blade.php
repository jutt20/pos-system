@extends('layouts.retailer')

@section('title', 'VoIP Services')
@section('page-title', 'VoIP Services')
@section('page-subtitle', 'Business phone system management')

@section('content')
    <div class="mb-4">
        <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="row mb-4">
        <!-- VoIP Activation -->
        <div class="col-md-6">
            <div class="card border-warning h-100">
                <div class="card-body">
                    <h5 class="card-title text-orange">
                        <i class="fas fa-phone-alt me-2"></i>VoIP Activation
                    </h5>
                    <p class="card-text">
                        Set up individual VoIP phone services for customers with automatic email notifications and setup instructions.
                    </p>
                    <ul class="ps-3">
                        <li>Choose from available VoIP plans</li>
                        <li>Generate phone numbers automatically</li>
                        <li>Send setup instructions via email</li>
                        <li>Commission-based earnings</li>
                    </ul>
                    <a href="#" class="btn btn-warning mt-3">Start VoIP Activation <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Bulk VoIP Activation -->
        <div class="col-md-6">
            <div class="card border-warning h-100">
                <div class="card-body">
                    <h5 class="card-title text-orange">
                        <i class="fas fa-users-cog me-2"></i>Bulk VoIP Activation
                    </h5>
                    <p class="card-text">
                        Process multiple VoIP activations at once with CSV export capabilities and bulk email notifications.
                    </p>
                    <ul class="ps-3">
                        <li>Activate multiple lines simultaneously</li>
                        <li>Export activation data to CSV</li>
                        <li>Bulk email notifications</li>
                        <li>Streamlined workflow</li>
                    </ul>
                    <a href="#" class="btn btn-warning mt-3">Start Bulk Activation <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6>Active VoIP Lines</h6>
                    <h3 class="text-orange">247</h3>
                    <i class="fas fa-phone-alt text-orange"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6>This Month</h6>
                    <h3>89</h3>
                    <i class="fas fa-user-friends text-orange"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6>Revenue</h6>
                    <h3 class="text-success">${{ number_format(2847, 2) }}</h3>
                    <i class="fas fa-dollar-sign text-success"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
