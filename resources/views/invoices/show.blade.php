@extends('layouts.app')

@section('title', 'Invoice #' . $invoice->invoice_number)

@section('actions')
<div class="btn-group">
    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline-primary">
        <i class="bi bi-pencil"></i> Edit
    </a>
    <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-outline-success">
        <i class="bi bi-download"></i> Download PDF
    </a>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Invoices
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Invoice Details</h5>
                <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning') }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </div>
            <div class="card-body">
                <!-- Invoice Header -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Invoice Number</h6>
                        <p class="h5">{{ $invoice->invoice_number }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h6 class="text-muted">Invoice Date</h6>
                        <p>{{ $invoice->billing_date->format('M d, Y') }}</p>
                        @if($invoice->due_date)
                        <h6 class="text-muted mt-2">Due Date</h6>
                        <p>{{ $invoice->due_date->format('M d, Y') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Bill To</h6>
                        <address>
                            <strong>{{ $invoice->customer->name }}</strong><br>
                            {{ $invoice->customer->email }}<br>
                            {{ $invoice->customer->phone }}<br>
                            @if($invoice->customer->address)
                            {{ $invoice->customer->address }}<br>
                            @endif
                            @if($invoice->customer->city)
                            {{ $invoice->customer->city }}, {{ $invoice->customer->state }} {{ $invoice->customer->zip_code }}
                            @endif
                        </address>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h6 class="text-muted">Created By</h6>
                        <p>{{ $invoice->employee->name }}</p>
                        <p class="text-muted">{{ $invoice->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Plan</th>
                                <th>SKU</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->plan ?? '-' }}</td>
                                <td>{{ $item->sku ?? '-' }}</td>
                                <td class="text-end">{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-end">${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Subtotal:</th>
                                <th class="text-end">${{ number_format($invoice->subtotal, 2) }}</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-end">Tax (8%):</th>
                                <th class="text-end">${{ number_format($invoice->tax_amount, 2) }}</th>
                            </tr>
                            <tr class="table-active">
                                <th colspan="5" class="text-end">Total:</th>
                                <th class="text-end">${{ number_format($invoice->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($invoice->payment_method)
                <div class="mt-3">
                    <h6 class="text-muted">Payment Method</h6>
                    <p>{{ ucfirst(str_replace('_', ' ', $invoice->payment_method)) }}</p>
                </div>
                @endif

                @if($invoice->notes)
                <div class="mt-3">
                    <h6 class="text-muted">Notes</h6>
                    <p>{{ $invoice->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                @if($invoice->status !== 'paid')
                <form method="POST" action="{{ route('invoices.update', $invoice) }}" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="status" class="form-label">Update Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="draft" {{ $invoice->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="sent" {{ $invoice->status === 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                    
                    @if($invoice->status !== 'paid')
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select">
                            <option value="">Select Method</option>
                            <option value="cash" {{ $invoice->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ $invoice->payment_method === 'card' ? 'selected' : '' }}>Card</option>
                            <option value="bank_transfer" {{ $invoice->payment_method === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="check" {{ $invoice->payment_method === 'check' ? 'selected' : '' }}>Check</option>
                        </select>
                    </div>
                    @endif
                    
                    <button type="submit" class="btn btn-primary w-100">Update Invoice</button>
                </form>
                @endif

                <div class="d-grid gap-2">
                    <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-outline-success">
                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                    </a>
                    
                    @if($invoice->status !== 'paid')
                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit Invoice
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Invoice Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Summary</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h6 class="text-muted mb-1">Items</h6>
                            <h5 class="mb-0">{{ $invoice->items->count() }}</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6 class="text-muted mb-1">Total</h6>
                        <h5 class="mb-0 text-success">${{ number_format($invoice->total_amount, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
