@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Invoice #{{ $invoice->invoice_number }}</h2>
                <div class="btn-group">
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Invoices
                    </a>
                    @can('manage billing')
                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit Invoice
                    </a>
                    @endcan
                    <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-success">
                        <i class="fas fa-file-pdf me-1"></i>
                        Download PDF
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Invoice Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Bill To:</h6>
                                    <strong>{{ $invoice->customer->name }}</strong><br>
                                    {{ $invoice->customer->email }}<br>
                                    {{ $invoice->customer->phone }}<br>
                                    @if($invoice->customer->address)
                                        {{ $invoice->customer->address }}
                                    @endif
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h6 class="text-muted">Invoice Information:</h6>
                                    <strong>Invoice #:</strong> {{ $invoice->invoice_number }}<br>
                                    <strong>Date:</strong> {{ $invoice->formatted_invoice_date }}<br>
                                    <strong>Due Date:</strong> {{ $invoice->formatted_due_date }}<br>
                                    <strong>Status:</strong> 
                                    @if($invoice->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($invoice->status === 'sent')
                                        <span class="badge bg-info">Sent</span>
                                    @elseif($invoice->status === 'overdue')
                                        <span class="badge bg-danger">Overdue</span>
                                    @elseif($invoice->status === 'cancelled')
                                        <span class="badge bg-secondary">Cancelled</span>
                                    @else
                                        <span class="badge bg-warning">{{ ucfirst($invoice->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Description</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Unit Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->items as $item)
                                        <tr>
                                            <td>{{ $item->description }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="text-end">${{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="3" class="text-end">Subtotal:</th>
                                            <th class="text-end">${{ number_format($invoice->subtotal, 2) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-end">Tax (8%):</th>
                                            <th class="text-end">${{ number_format($invoice->tax_amount, 2) }}</th>
                                        </tr>
                                        <tr class="table-primary">
                                            <th colspan="3" class="text-end">Total Amount:</th>
                                            <th class="text-end">${{ number_format($invoice->total_amount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            @if($invoice->notes)
                            <div class="mt-4">
                                <h6 class="text-muted">Notes:</h6>
                                <p>{{ $invoice->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Invoice Actions</h5>
                        </div>
                        <div class="card-body">
                            @can('manage billing')
                            <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="draft" {{ $invoice->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="sent" {{ $invoice->status === 'sent' ? 'selected' : '' }}>Sent</option>
                                        <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                        <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
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
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-1"></i>
                                    Update Invoice
                                </button>
                            </form>
                            @endcan

                            <hr>

                            <div class="d-grid gap-2">
                                <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-success">
                                    <i class="fas fa-file-pdf me-1"></i>
                                    Download PDF
                                </a>
                                
                                @can('manage billing')
                                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i>
                                    Edit Invoice
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Created By</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>{{ $invoice->employee->name }}</strong></p>
                            <p class="text-muted mb-0">{{ $invoice->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
