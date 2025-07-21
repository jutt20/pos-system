@extends('layouts.app')

@section('title', 'Employee Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Employee Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
            <i class="fas fa-plus me-1"></i> Add New Employee
        </button>
    </div>

    <!-- Filters and Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" id="roleFilter">
                        <option value="">All Roles</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                        <option value="Manager">Manager</option>
                        <option value="Billing Agent">Billing Agent</option>
                        <option value="Sales Agent">Sales Agent</option>
                        <option value="Retailer">Retailer</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search employees...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Employee</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Hire Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $employee->name }}</strong>
                                        @if($employee->position)
                                            <br><small class="text-muted">{{ $employee->position }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $employee->username }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone ?? 'N/A' }}</td>
                            <td>
                                @foreach($employee->roles as $role)
                                    @if($role->name === 'Super Admin')
                                        <span class="badge bg-danger">{{ $role->name }}</span>
                                    @elseif($role->name === 'Admin')
                                        <span class="badge bg-warning">{{ $role->name }}</span>
                                    @elseif($role->name === 'Manager')
                                        <span class="badge bg-info">{{ $role->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $role->name }}</span>
                                    @endif
                                @endforeach
                                @if($employee->roles->isEmpty())
                                    <span class="badge bg-light text-dark">No Role</span>
                                @endif
                            </td>
                            <td>
                                @if($employee->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'N/A' }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('employees.show', $employee) }}"><i class="fas fa-eye me-2"></i> View Details</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" data-employee-id="{{ $employee->id }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                        @if(!$employee->isSuperAdmin() && $employee->id !== auth()->id())
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this employee?')">
                                                    <i class="fas fa-trash-alt me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                        @endif
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
                    Showing <span class="fw-semibold">1-{{ count($employees) }}</span> of <span class="fw-semibold">{{ count($employees) }}</span> employees
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

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST">
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
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position">
                        </div>
                        <div class="col-md-6">
                            <label for="hire_date" class="form-label">Hire Date</label>
                            <input type="date" class="form-control" id="hire_date" name="hire_date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Roles <span class="text-danger">*</span></label>
                            <div class="row">
                                @foreach($roles as $role)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}">
                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
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
                    <button type="submit" class="btn btn-primary">Create Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEmployeeForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Form fields will be populated via JavaScript -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading employee data...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Employee</button>
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
    // Handle edit employee modal
    const editEmployeeModal = document.getElementById('editEmployeeModal');
    if (editEmployeeModal) {
        editEmployeeModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const employeeId = button.getAttribute('data-employee-id');
            const form = document.getElementById('editEmployeeForm');
            
            // Set the form action URL
            form.action = `/employees/${employeeId}`;
            
            // Here you would typically fetch the employee data via AJAX
            // and populate the form fields
            // For demo purposes, we'll just show a placeholder
            
            setTimeout(() => {
                const modalBody = form.querySelector('.modal-body');
                modalBody.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" value="Employee Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email" value="employee@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_username" name="username" value="employee_username" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone" value="+1234567890">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="edit_position" name="position" value="Sales Agent">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_hire_date" class="form-label">Hire Date</label>
                            <input type="date" class="form-control" id="edit_hire_date" name="hire_date" value="2023-01-15">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_password" class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Roles <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit_role_1" name="roles[]" value="Admin" checked>
                                        <label class="form-check-label" for="edit_role_1">Admin</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit_role_2" name="roles[]" value="Manager">
                                        <label class="form-check-label" for="edit_role_2">Manager</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit_role_3" name="roles[]" value="Sales Agent">
                                        <label class="form-check-label" for="edit_role_3">Sales Agent</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_status" name="status" value="active" checked>
                                <label class="form-check-label" for="edit_status">Active</label>
                            </div>
                        </div>
                    </div>
                `;
            }, 500);
        });
    }
</script>
@endsection
