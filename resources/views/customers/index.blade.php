@extends('layouts.app')

@section('title', 'Customer Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Customer Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="fas fa-plus me-1"></i> Add New Customer
        </button>
    </div>

    <!-- Filters and Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="prepaidFilter">
                        <option value="">All Types</option>
                        <option value="prepaid">Prepaid</option>
                        <option value="postpaid">Postpaid</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search customers...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company</th>
                            <th>Balance</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $customer->name }}</strong>
                                        @if($customer->id_number)
                                            <br><small class="text-muted">ID: {{ $customer->id_number }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                            <td>{{ $customer->company ?? 'N/A' }}</td>
                            <td>
                                @if($customer->balance > 0)
                                    <span class="text-success fw-semibold">${{ number_format($customer->balance, 2) }}</span>
                                @elseif($customer->balance < 0)
                                    <span class="text-danger fw-semibold">${{ number_format(abs($customer->balance), 2) }}</span>
                                @else
                                    <span class="text-muted">${{ number_format($customer->balance, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($customer->prepaid_status === 'prepaid')
                                    <span class="badge bg-info">Prepaid</span>
                                @else
                                    <span class="badge bg-primary">Postpaid</span>
                                @endif
                            </td>
                            <td>
                                @if($customer->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($customer->status === 'inactive')
                                    <span class="badge bg-danger">Inactive</span>
                                @else
                                    <span class="badge bg-warning">Suspended</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('customers.show', $customer) }}"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                        <li><a class="dropdown-item" href="{{ route('customers.edit', $customer) }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#adjustBalanceModal" data-customer-id="{{ $customer->id }}" data-customer-name="{{ $customer->name }}"><i class="fas fa-dollar-sign me-2"></i> Adjust Balance</a></li>
                                        <li><a class="dropdown-item" href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}"><i class="fas fa-file-invoice me-2"></i> Create Invoice</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this customer?')">
                                                    <i class="fas fa-trash-alt me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing <span class="fw-semibold">1-{{ count($customers) }}</span> of <span class="fw-semibold">{{ count($customers) }}</span> customers
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" name="company">
                        </div>
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>
                        <div class="col-md-4">
                            <label for="zip_code" class="form-label">ZIP Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code">
                        </div>
                        <div class="col-md-6">
                            <label for="id_number" class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="id_number" name="id_number">
                        </div>
                        <div class="col-md-6">
                            <label for="id_type" class="form-label">ID Type</label>
                            <select class="form-select" id="id_type" name="id_type">
                                <option value="">Select ID Type</option>
                                <option value="Passport">Passport</option>
                                <option value="Driver's License">Driver's License</option>
                                <option value="National ID">National ID</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="col-md-6">
                            <label for="prepaid_status" class="form-label">Account Type</label>
                            <select class="form-select" id="prepaid_status" name="prepaid_status">
                                <option value="postpaid">Postpaid</option>
                                <option value="prepaid">Prepaid</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="assigned_employee_id" class="form-label">Assigned Employee</label>
                            <select class="form-select" id="assigned_employee_id" name="assigned_employee_id">
                                <option value="">None</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="active" checked>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Adjust Balance Modal -->
<div class="modal fade" id="adjustBalanceModal" tabindex="-1" aria-labelledby="adjustBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustBalanceModalLabel">Adjust Customer Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="adjustBalanceForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control" id="customerName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="adjustment_type" class="form-label">Adjustment Type</label>
                        <select class="form-select" id="adjustment_type" name="adjustment_type" required>
                            <option value="add">Add Credit</option>
                            <option value="subtract">Subtract Credit</option>
                            <option value="set">Set Exact Amount</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Apply Adjustment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: transparent;
        border: none;
        color: #6c757d;
    }
    
    .btn-icon:hover {
        background-color: rgba(108, 117, 125, 0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    // Handle adjust balance modal
    const adjustBalanceModal = document.getElementById('adjustBalanceModal');
    if (adjustBalanceModal) {
        adjustBalanceModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const customerId = button.getAttribute('data-customer-id');
            const customerName = button.getAttribute('data-customer-name');
            const form = document.getElementById('adjustBalanceForm');
            
            // Set the form action URL
            form.action = `/customers/${customerId}/adjust-balance`;
            
            // Set the customer name
            document.getElementById('customerName').value = customerName;
        });
    }
</script>
@endsection
