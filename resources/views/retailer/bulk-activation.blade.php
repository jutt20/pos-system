@extends('layouts.retailer')

@section('title', 'Bulk Activation')
@section('page-title', 'Bulk Activation')
@section('page-subtitle', 'Upload CSV file to activate multiple SIMs')

@section('content')
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="content-section mb-4">
    <h5><i class="fas fa-file-csv text-dark me-2"></i> CSV File Format Instructions</h5>
    <p class="mb-2">Follow these guidelines to prepare your bulk activation file</p>
    <ul>
        <li><strong>iccid</strong> - SIM card ICCID (20 digits)</li>
        <li><strong>sim_type</strong> - Physical or eSIM</li>
        <li><strong>plan</strong> - Service plan name</li>
        <li><strong>customer_name</strong> - Full customer name</li>
        <li><strong>phone_number</strong> - Customer phone number</li>
        <li><strong>email</strong> - Customer email (optional)</li>
        <li><strong>address</strong> - Customer address (optional)</li>
    </ul>
    <button class="btn btn-outline-dark">
        <i class="fas fa-download me-2"></i> Download Template
    </button>
</div>

<div class="content-section">
    <h5 class="mb-3">Upload CSV File</h5>
    <p>Select your prepared CSV file for bulk activation</p>

    <div class="border border-dashed rounded p-5 text-center" style="border-color: #e5e7eb;">
        <input type="file" hidden id="csvUpload">
        <label for="csvUpload" class="d-block">
            <i class="fas fa-upload fa-2x text-muted mb-2"></i><br>
            <span class="fw-bold text-muted">Choose CSV file</span><br>
            <small class="text-muted">Click to browse or drag and drop your CSV file here</small>
        </label>
    </div>
</div>
@endsection
