@extends('layouts.retailer')

@section('title', 'WiFi Enable Upload')
@section('page-title', 'WiFi Enable Upload')
@section('page-subtitle', 'Enable WiFi services for multiple devices')

@section('content')
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="content-section mb-4">
    <h5><i class="fas fa-file-csv text-dark me-2"></i> WiFi Enable File Format Instructions</h5>
    <p class="mb-2">Upload a CSV file to enable WiFi services for multiple customers</p>
    <ul>
        <li><strong>iccid</strong> - SIM card ICCID (20 digits)</li>
        <li><strong>phone_number</strong> - Device phone number</li>
        <li><strong>wifi_plan</strong> - WiFi service plan (Basic WiFi, Premium WiFi, etc.)</li>
        <li><strong>customer_name</strong> - Customer name (optional)</li>
    </ul>

    <div class="alert alert-primary d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-info-circle"></i> WiFi services will be enabled on existing active Nexitel lines. Ensure all ICCIDs correspond to active subscriptions.
    </div>

    <button class="btn btn-outline-dark">
        <i class="fas fa-download me-2"></i> Download Template
    </button>
</div>

<div class="content-section">
    <h5 class="mb-3">Upload WiFi Enable File</h5>
    <p>Select your prepared CSV file to enable WiFi services</p>

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
