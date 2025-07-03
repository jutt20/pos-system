@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Invoice Management</h2>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Create New Invoice
                </a>
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
                                    <th>Date</th>
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
                                            @elseif($invoice->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($invoice->status === 'overdue')
                                                <span class="badge bg-danger">Overdue</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($invoice->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                                        <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="background: #fee2e2; color: #991b1b;" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No invoices found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
