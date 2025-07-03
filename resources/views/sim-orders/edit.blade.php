@extends('layouts.app')

@section('title', 'Edit SIM Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit SIM Order #{{ $simOrder->order_number }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sim-orders.update', $simOrder) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Order Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="pending" {{ $simOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="shipped" {{ $simOrder->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $simOrder->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $simOrder->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tracking_number" class="form-label">Tracking Number</label>
                                <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" 
                                       id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $simOrder->tracking_number) }}">
                                @error('tracking_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes', $simOrder->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info">
                        <h6>Order Details (Read Only)</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Vendor:</strong> {{ $simOrder->vendor }}</p>
                                <p><strong>Brand:</strong> {{ $simOrder->brand }}</p>
                                <p><strong>SIM Type:</strong> {{ $simOrder->sim_type }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Quantity:</strong> {{ number_format($simOrder->quantity) }}</p>
                                <p><strong>Cost Per SIM:</strong> ${{ number_format($simOrder->cost_per_sim, 2) }}</p>
                                <p><strong>Total Cost:</strong> ${{ number_format($simOrder->total_cost, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('sim-orders.show', $simOrder) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
