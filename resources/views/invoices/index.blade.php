@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Invoice Management</h1>
        <a href="{{ route('invoices.create') }}" class="btn-primary">Create Invoice</a>
    </div>

    <div class="content-section">
        <h2 class="section-title">All Invoices</h2>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>{{ $invoice->billing_date->format('M d, Y') }}</td>
                    <td>${{ number_format($invoice->total_amount, 2) }}</td>
                    <td>
                        <span class="status-badge {{ $invoice->status == 'paid' ? 'status-paid' : 'status-unpaid' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn-sm">View</a>
                            <a href="{{ route('invoices.pdf', $invoice) }}" class="btn-sm">PDF</a>
                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn-sm">Edit</a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm" style="background: #fee2e2; color: #991b1b;" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        No invoices found. <a href="{{ route('invoices.create') }}">Create your first invoice</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection
