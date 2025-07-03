@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Invoice Management</h2>
                @can('manage billing')
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Create New Invoice
                </a>
                @endcan
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-invoice me-2"></i>
                        All Invoices
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Invoice Date</th>
                                    <th>Due Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>
                                            <strong>#{{ $invoice->invoice_number }}</strong>
                                        </td>
                                        <td>{{ $invoice->customer->name }}</td>
                                        <td>${{ number_format($invoice->total_amount, 2) }}</td>
                                        <td>
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
                                        </td>
                                        <td>{{ $invoice->formatted_invoice_date }}</td>
                                        <td>{{ $invoice->formatted_due_date }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('manage billing')
                                                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-sm btn-outline-success" title="Download PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                @can('manage billing')
                                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-file-invoice fa-3x mb-3 text-muted"></i>
                                            <p>No invoices found.</p>
                                            @can('manage billing')
                                            <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                                                Create Your First Invoice
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($invoices->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $invoices->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
