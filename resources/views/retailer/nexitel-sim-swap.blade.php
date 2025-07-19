@extends('layouts.retailer')

@section('title', 'Nexitel SIM Swap')

@section('page-title', 'Nexitel SIM Swap')
@section('page-subtitle', 'Replace your SIM card and transfer your service')

@section('content')
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="p-4 rounded bg-light border" style="background-color: #fff7ed;">
    <h6 class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Important Notice</h6>
    <p class="small mb-0">
        SIM swap will temporarily interrupt your service. Please ensure you have access to your new SIM card before proceeding. The process typically takes 5-10 minutes to complete.
    </p>
</div>

<div class="row g-4 mt-4">
    <div class="col-md-8">
        <div class="p-4 bg-white rounded shadow-sm border">
            <h5 class="mb-4"><i class="fas fa-phone-alt me-2 text-orange"></i> SIM Swap Request</h5>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" value="+1 (555) 123-4567" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nexitel Network</label>
                    <select class="form-select">
                        <option>Select your network...</option>
                        <option>AT&T</option>
                        <option>T-Mobile</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current SIM ICCID</label>
                    <input type="text" class="form-control" value="89014103211118510720" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">New SIM ICCID</label>
                    <input type="text" class="form-control" value="89014103211118510721">
                </div>

                <div class="mb-4">
                    <label class="form-label">Reason for SIM Swap</label>
                    <select class="form-select">
                        <option>Select reason...</option>
                        <option>Lost SIM</option>
                        <option>Damaged SIM</option>
                        <option>Other</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning w-100">
                    <i class="fas fa-sync-alt me-2"></i> Request SIM Swap
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="p-4 bg-white rounded shadow-sm border">
            <h6 class="fw-bold mb-3">Swap Summary</h6>
            <ul class="list-unstyled small">
                <li class="mb-2"><strong>Phone:</strong> <span class="text-muted">Not entered</span></li>
                <li class="mb-2"><strong>Network:</strong> <span class="text-muted">Not selected</span></li>
                <li class="mb-2"><strong>Reason:</strong> <span class="text-muted">Not selected</span></li>
            </ul>
            <hr>
            <p class="small mb-0">Process Time:<br><strong>5-10 minutes</strong></p>
        </div>
    </div>
</div>
@endsection
