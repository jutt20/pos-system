@extends('layouts.retailer')

@section('title', 'Nexitel Activation Report')

@section('page-title', 'Nexitel Activation Report')
@section('page-subtitle', 'View and manage activation records')

@section('content')
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="content-section">
    <div class="d-flex align-items-center gap-3 mb-4">
        <input type="text" class="form-control" placeholder="Search by phone number, customer name, or activation ID...">
        <button class="btn btn-primary">
            <i class="fas fa-calendar-alt me-2"></i> Filter by Date
        </button>
    </div>

    <div class="d-flex flex-column gap-3">

        @php
            $records = [
                ['id' => 'ACT-2025-001', 'date' => '2025-01-12', 'name' => 'John Doe', 'phone' => '+1 (555) 123-4567', 'network' => 'Nexitel Purple', 'networkClass' => 'purple', 'plan' => 'Unlimited 30', 'status' => 'Completed', 'statusClass' => 'success'],
                ['id' => 'ACT-2025-002', 'date' => '2025-01-12', 'name' => 'Jane Smith', 'phone' => '+1 (555) 987-6543', 'network' => 'Nexitel Blue', 'networkClass' => 'info', 'plan' => 'Unlimited 40', 'status' => 'Pending', 'statusClass' => 'warning text-dark'],
                ['id' => 'ACT-2025-003', 'date' => '2025-01-11', 'name' => 'Mike Johnson', 'phone' => '+1 (555) 456-7890', 'network' => 'Nexitel Purple', 'networkClass' => 'purple', 'plan' => 'Prepaid 25', 'status' => 'Failed', 'statusClass' => 'danger'],
            ];
        @endphp

        @foreach ($records as $record)
        <div class="p-4 bg-white rounded shadow-sm border d-flex align-items-center justify-content-between" style="gap: 20px;">
            <div style="min-width: 150px;">
                <div class="fw-bold">{{ $record['id'] }}</div>
                <div class="text-muted small">{{ $record['date'] }}</div>
            </div>

            <div style="min-width: 220px;">
                <div class="fw-bold">{{ $record['name'] }}</div>
                <div class="text-muted small"><i class="fas fa-phone-alt me-2"></i>{{ $record['phone'] }}</div>
            </div>

            <div style="min-width: 150px;">
                <span class="badge bg-{{ $record['networkClass'] }}">{{ $record['network'] }}</span>
            </div>

            <div style="min-width: 150px;">
                <div class="fw-bold">{{ $record['plan'] }}</div>
                <div class="text-muted small">Plan</div>
            </div>

            <div style="min-width: 120px;">
                <span class="badge bg-{{ $record['statusClass'] }} bg-opacity-25">{{ $record['status'] }}</span>
            </div>

            <div style="min-width: 120px;">
                <button class="btn btn-outline-secondary btn-sm">View Details</button>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection
