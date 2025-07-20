@extends('layouts.retailer')

@section('title', 'Nexitel Recharge')

@section('page-title', 'Nexitel Recharge')
@section('page-subtitle', 'Top up your Nexitel phone instantly')

@section('content')
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="content-section">
            <h5 class="mb-3"><i class="fas fa-bolt me-2"></i> Recharge Details</h5>

            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" value="+1 (555) 123-4567">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nexitel Network</label>
                    <select class="form-select">
                        <option selected>Select your Nexitel network...</option>
                        <option>Nexitel Purple</option>
                        <option>Nexitel Blue</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Recharge Amount</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-secondary">$10</button>
                        <button type="button" class="btn btn-outline-secondary">$20</button>
                        <button type="button" class="btn btn-outline-primary active">$25</button>
                        <button type="button" class="btn btn-outline-secondary">$30</button>
                        <button type="button" class="btn btn-outline-secondary">$50</button>
                        <button type="button" class="btn btn-outline-secondary">$75</button>
                        <button type="button" class="btn btn-outline-secondary">$100</button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Custom Amount</label>
                    <input type="text" class="form-control" value="25">
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-credit-card me-2"></i> Recharge $25
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="content-section">
            <h5>Recharge Summary</h5>
            <ul class="list-unstyled mt-3">
                <li class="mb-2">Phone Number: <span class="text-muted">Not entered</span></li>
                <li class="mb-2">Network: <span class="text-muted">Not selected</span></li>
                <li class="mb-2">Amount: <span class="text-purple fw-bold">$25</span></li>
                <li class="mb-2">Total: <span class="text-purple fw-bold">$25</span></li>
            </ul>
        </div>

        <div class="content-section mt-4">
            <h5>Why Choose Nexitel?</h5>
            <ul class="list-unstyled mt-3">
                <li class="mb-2"><i class="fas fa-bolt text-success me-2"></i> Instant Top-up</li>
                <li class="mb-2"><i class="fas fa-clock text-success me-2"></i> 24/7 Availability</li>
                <li class="mb-2"><i class="fas fa-shield-alt text-success me-2"></i> Secure Payments</li>
                <li class="mb-2"><i class="fas fa-money-bill text-success me-2"></i> No Hidden Fees</li>
            </ul>
        </div>
    </div>
</div>
@endsection
