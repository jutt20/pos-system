@extends('layouts.retailer')

@section('title', 'Daily Reports')
@section('page-title', 'Daily Reports')
@section('page-subtitle', 'View your daily performance and analytics')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn-outline">
        <i class="fas fa-arrow-left me-2"></i>
        Back to Dashboard
    </a>
</div>

<!-- Coming Soon -->
<div class="content-section text-center">
    <i class="fas fa-chart-line fa-4x text-muted mb-4"></i>
    <h3 class="text-muted mb-3">Daily Reports Coming Soon</h3>
    <p class="text-muted mb-4">We're working on bringing you detailed daily reports and analytics.</p>
    <a href="{{ route('retailer.dashboard') }}" class="btn-primary">
        <i class="fas fa-arrow-left me-2"></i>
        Back to Dashboard
    </a>
</div>
@endsection
