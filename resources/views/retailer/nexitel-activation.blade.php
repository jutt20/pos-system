@extends('layouts.retailer')

@section('title', 'Nexitel Activation')

@section('page-title', 'Nexitel Activation')
@section('page-subtitle', 'Activate your new Nexitel wireless service')

@section('content')
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="content-section">
            <h5 class="mb-3">Customer Information</h5>

            <form action="#" method="POST">
                @csrf
                <h6 class="mt-4 mb-3">SIM Card Information</h6>
                <div class="mb-3">
                    <label for="iccid" class="form-label">ICCID Number</label>
                    <input type="text" class="form-control" id="iccid" name="iccid" value="89014103211118510720" readonly>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="simType" class="form-label">SIM Type</label>
                        <select id="simType" class="form-select" name="simType">
                            <option selected>Select SIM type...</option>
                            <option>Physical SIM</option>
                            <option>eSIM</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="network" class="form-label">Nexitel Network</label>
                        <select id="network" class="form-select" name="network">
                            <option selected>Select network...</option>
                            <option>AT&T</option>
                            <option>T-Mobile</option>
                        </select>
                    </div>
                </div>

                <h6 class="mt-4 mb-3">Plan Selection</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="plan" class="form-label">Select Plan</label>
                        <select id="plan" class="form-select" name="plan">
                            <option selected>Choose a plan...</option>
                            <option>Unlimited 5G</option>
                            <option>Basic 4G</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="duration" class="form-label">Plan Duration</label>
                        <select id="duration" class="form-select" name="duration">
                            <option selected>Select duration...</option>
                            <option>30 Days</option>
                            <option>90 Days</option>
                        </select>
                    </div>
                </div>

                <h6 class="mt-4 mb-3">Customer Information</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" value="John">
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" value="Doe">
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" value="123 Main Street">
                    </div>
                    <div class="col-md-6">
                        <label for="state" class="form-label">State</label>
                        <select id="state" class="form-select">
                            <option selected>Select state...</option>
                            <option>California</option>
                            <option>Texas</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="zip" class="form-label">ZIP Code</label>
                        <input type="text" class="form-control" id="zip" value="12345">
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" value="john.doe@email.com">
                    </div>
                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" value="" id="portNumber">
                    <label class="form-check-label" for="portNumber">
                        I want to keep my existing phone number
                    </label>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Complete Activation</button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-section">
            <h5>What's Included</h5>
            <ul class="list-unstyled mt-3">
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> 5G Network Access</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> No Contract Required</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Nationwide Coverage</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Free Number Porting</li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> 24/7 Customer Support</li>
            </ul>
        </div>
    </div>
</div>
@endsection
