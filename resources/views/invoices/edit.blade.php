@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Edit Invoice #{{ $invoice->invoice_number }}</h2>
                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Back to Invoice
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Invoice Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="draft" {{ $invoice->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="sent" {{ $invoice->status === 'sent' ? 'selected' : '' }}>Sent</option>
                                        <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                        <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ $invoice->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="card" {{ $invoice->payment_method === 'card' ? 'selected' : '' }}>Card</option>
                                        <option value="bank_transfer" {{ $invoice->payment_method === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="check" {{ $invoice->payment_method === 'check' ? 'selected' : '' }}>Check</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror" placeholder="Add any additional notes...">{{ old('notes', $invoice->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Update Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Invoice Items (Read-only) -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Invoice Items</h5>
                    <small class="text-muted">Items cannot be modified after invoice creation</small>
                </div>
                <div class="card-body">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
