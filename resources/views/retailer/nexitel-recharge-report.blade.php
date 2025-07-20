@extends('layouts.retailer')

@section('title', 'Nexitel Recharge Report')

@section('page-title', 'Nexitel Recharge Report')
@section('page-subtitle', 'View and manage recharge transactions')

@section('content')
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="content-section">
    <div class="d-flex align-items-center gap-3 mb-4">
        <input type="text" class="form-control" placeholder="Search by phone number, recharge ID, or transaction ID...">
        <button class="btn btn-primary">
            <i class="fas fa-calendar-alt me-2"></i> Filter by Date
        </button>
    </div>

    <div class="d-flex flex-column gap-3">

        @php
            $records = [
                ['id' => 'RCH-2025-001', 'date' => '2025-01-12 14:30', 'phone' => '+1 (555) 123-4567', 'txn' => 'TXN-123456789', 'network' => 'Nexitel Purple', 'networkClass' => 'purple', 'amount' => '$50', 'amountClass' => 'text-success', 'status' => 'Completed', 'statusClass' => 'success'],
                ['id' => 'RCH-2025-002', 'date' => '2025-01-12 15:45', 'phone' => '+1 (555) 987-6543', 'txn' => 'TXN-123456790', 'network' => 'Nexitel Blue', 'networkClass' => 'info', 'amount' => '$25', 'amountClass' => 'text-primary', 'status' => 'Pending', 'statusClass' => 'warning text-dark'],
                ['id' => 'RCH-2025-003', 'date' => '2025-01-12 10:15', 'phone' => '+1 (555) 456-7890', 'txn' => 'TXN-123456791', 'network' => 'Nexitel Purple', 'networkClass' => 'purple', 'amount' => '$100', 'amountClass' => 'text-danger', 'status' => 'Failed', 'statusClass' => 'danger'],
                ['id' => 'RCH-2025-004', 'date' => '2025-01-11 16:20', 'phone' => '+1 (555) 321-0987', 'txn' => 'TXN-123456792', 'network' => 'Nexitel Blue', 'networkClass' => 'info', 'amount' => '$75', 'amountClass' => 'text-success', 'status' => 'Completed', 'statusClass' => 'success'],
            ];
        @endphp

        @foreach ($records as $record)
        <div class="p-4 bg-white rounded shadow-sm border d-flex align-items-center justify-content-between" style="gap: 20px;">
            <div style="min-width: 200px;">
                <div class="fw-bold">{{ $record['id'] }}</div>
                <div class="text-muted small">{{ $record['date'] }}</div>
            </div>

            <div style="min-width: 220px;">
                <div class="fw-bold"><i class="fas fa-phone-alt me-2 text-muted"></i> {{ $record['phone'] }}</div>
                <div class="text-muted small">{{ $record['txn'] }}</div>
            </div>

            <div style="min-width: 150px;">
                <span class="badge bg-light text-dark border border-1 border-purple text-purple" style="background-color: #f4e9ff;">{{ $record['network'] }}</span>
            </div>

            <div class="text-center" style="min-width: 100px;">
                <div class="fw-bold {{ $record['amountClass'] }}">{{ $record['amount'] }}</div>
                <div class="text-muted small">Amount</div>
            </div>

            <div style="min-width: 120px;">
                <span class="badge bg-success bg-opacity-25 text-success">{{ $record['status'] }}</span>
            </div>

            <div style="min-width: 120px;">
                <button class="btn btn-outline-secondary btn-sm">View Details</button>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection
