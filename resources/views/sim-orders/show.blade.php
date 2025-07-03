@extends('layouts.app')

@section('title', 'SIM Order Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">SIM Order #{{ $simOrder->order_number }}</h5>
                <div>
                    <span class="badge badge-{{ $simOrder->status == 'delivered' ? 'success' : ($simOrder->status == 'cancelled' ? 'danger' : 'warning') }}">
                        {{ ucfirst($simOrder->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Order Number:</strong></td>
                                <td>{{ $simOrder->order_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Vendor:</strong></td>
                                <td>{{ $simOrder->vendor }}</td>
                            </tr>
                            <tr>
                                <td><strong>Brand:</strong></td>
                                <td>{{ $simOrder->brand }}</td>
                            </tr>
                            <tr>
                                <td><strong>SIM Type:</strong></td>
                                <td>{{ $simOrder->sim_type }}</td>
                            </tr>
                            <tr>
                                <td><strong>Quantity:</strong></td>
                                <td>{{ number_format($simOrder->quantity) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Order Date:</strong></td>
                                <td>{{ $simOrder->order_date->format('M d, Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Cost Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Cost Per SIM:</strong></td>
                                <td>${{ number_format($simOrder->cost_per_sim, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Cost:</strong></td>
                                <td><strong>${{ number_format($simOrder->total_cost, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $simOrder->status == 'delivered' ? 'success' : ($simOrder->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($simOrder->status) }}
                                    </span>
                                </td>
                            </tr>
                            @if($simOrder->tracking_number)
                            <tr>
                                <td><strong>Tracking Number:</strong></td>
                                <td>{{ $simOrder->tracking_number }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Ordered By:</strong></td>
                                <td>{{ $simOrder->employee->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($simOrder->notes)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Notes</h6>
                        <div class="alert alert-light">
                            {{ $simOrder->notes }}
                        </div>
                    </div>
                </div>
                @endif
                
                @if($simOrder->invoice_file)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Invoice File</h6>
                        <a href="{{ Storage::url($simOrder->invoice_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-file-pdf"></i> View Invoice File
                        </a>
                    </div>
                </div>
                @endif
                
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sim-orders.index') }}" class="btn btn-secondary">Back to Orders</a>
                            <div>
                                @can('manage orders')
                                    <a href="{{ route('sim-orders.edit', $simOrder) }}" class="btn btn-primary">Edit Order</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
