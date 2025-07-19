@extends('layouts.retailer')

@section('title', 'Nexitel Port-In Status')

@section('page-title', 'Nexitel Port-In Status')
@section('page-subtitle', 'Track your number porting requests')

@section('content')
<div class="mb-4">
    <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-title"><i class="fas fa-check-circle me-2 text-success"></i>Completed</div>
            <div class="stat-value">1</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-title"><i class="fas fa-clock me-2 text-primary"></i>In Progress</div>
            <div class="stat-value">1</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-title"><i class="fas fa-exclamation-circle me-2 text-warning"></i>Pending</div>
            <div class="stat-value">1</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-title"><i class="fas fa-times-circle me-2 text-danger"></i>Failed</div>
            <div class="stat-value">1</div>
        </div>
    </div>
</div>

<div class="content-section">
    <div class="d-flex align-items-center gap-3 mb-4">
        <input type="text" class="form-control" placeholder="Search by phone number, request ID, or customer name...">
        <button class="btn btn-primary">
            <i class="fas fa-calendar-alt me-2"></i> Filter by Date
        </button>
    </div>

    <div class="d-flex flex-column gap-4">

        @php
            $records = [
                ['id' => 'PORT-2025-001', 'name' => 'John Doe', 'phone' => '+1 (555) 123-4567', 'from' => 'Verizon', 'to' => 'Nexitel Purple', 'status' => 'Completed', 'statusClass' => 'success', 'submitted' => '2025-01-10', 'expected' => '2025-01-12', 'completed' => '2025-01-12', 'progress' => 3],
                ['id' => 'PORT-2025-002', 'name' => 'Jane Smith', 'phone' => '+1 (555) 987-6543', 'from' => 'T-Mobile', 'to' => 'Nexitel Blue', 'status' => 'In Progress', 'statusClass' => 'info', 'submitted' => '2025-01-11', 'expected' => '2025-01-13', 'progress' => 2],
                ['id' => 'PORT-2025-003', 'name' => 'Mike Johnson', 'phone' => '+1 (555) 456-7890', 'from' => 'AT&T', 'to' => 'Nexitel Purple', 'status' => 'Pending Validation', 'statusClass' => 'warning text-dark', 'submitted' => '2025-01-12', 'expected' => '2025-01-14', 'progress' => 1],
                ['id' => 'PORT-2025-004', 'name' => 'Sarah Wilson', 'phone' => '+1 (555) 321-0987', 'from' => 'Sprint', 'to' => 'Nexitel Blue', 'status' => 'Failed', 'statusClass' => 'danger', 'submitted' => '2025-01-09', 'expected' => '2025-01-11', 'progress' => 0],
            ];
        @endphp

        @foreach ($records as $record)
        <div class="p-4 bg-white rounded shadow-sm border">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="fw-bold text-{{ $record['statusClass'] }}">{{ $record['id'] }}</div>
                    <div class="fw-bold">{{ $record['name'] }}</div>
                    <div class="text-muted small">{{ $record['phone'] }}</div>
                </div>

                <div class="text-center">
                    <div class="text-muted small">From → To</div>
                    <div class="fw-bold">{{ $record['from'] }}</div>
                    <div><i class="fas fa-arrow-down"></i></div>
                    <span class="badge bg-light text-dark border border-1">{{ $record['to'] }}</span>
                </div>

                <div class="text-center" style="min-width: 150px;">
                    <span class="badge bg-{{ $record['statusClass'] }} bg-opacity-25">{{ $record['status'] }}</span><br>
                    <div class="small text-muted">Submitted: {{ $record['submitted'] }}</div>
                    <div class="small text-muted">Expected: {{ $record['expected'] }}</div>
                    @if(isset($record['completed']))
                        <div class="small text-success">Completed: {{ $record['completed'] }}</div>
                    @endif
                </div>

                <div>
                    <button class="btn btn-outline-secondary btn-sm mb-2">View Details</button>
                    @if($record['status'] === 'Failed')
                        <button class="btn btn-success btn-sm">Retry Request</button>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="d-flex gap-3">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 10px; height: 10px; border-radius: 50%; background-color: {{ $record['progress'] > $i ? '#22c55e' : '#d1d5db' }};"></div>
                        </div>
                    @endfor
                </div>
                <div class="small text-muted">Submitted &nbsp; Validating &nbsp; Complete</div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection
