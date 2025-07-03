@extends('layouts.app')

@section('title', 'Edit Invoice #' . $invoice->invoice_number)

@section('actions')
<a href="{{ route('invoices.show', $invoice) }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Back to Invoice
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Invoice</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('invoices.update', $invoice) }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select name="customer_id" id="customer_id" class="form-select" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->email }}
                                </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="draft" {{ $invoice->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ $invoice->status === 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                            @error('status')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="billing_date" class="form-label">Billing Date</label>
                            <input type="date" name="billing_date" id="billing_date" class="form-control" 
                                   value="{{ $invoice->billing_date->format('Y-m-d') }}" required>
                            @error('billing_date')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" 
                                   value="{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '' }}">
                            @error('due_date')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select">
                            <option value="">Select Payment Method</option>
                            <option value="cash" {{ $invoice->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ $invoice->payment_method === 'card' ? 'selected' : '' }}>Card</option>
                            <option value="bank_transfer" {{ $invoice->payment_method === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="check" {{ $invoice->payment_method === 'check' ? 'selected' : '' }}>Check</option>
                        </select>
                        @error('payment_method')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3">{{ $invoice->notes }}</textarea>
                        @error('notes')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Invoice Items</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $item->description }}</div>
                                    @if($item->plan)
                                    <small class="text-muted">{{ $item->plan }}</small>
                                    @endif
                                </td>
                                <td class="text-end">{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th colspan="2">Total:</th>
                                <th class="text-end">${{ number_format($invoice->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i> 
                    To modify items, create a new invoice or contact administrator.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
