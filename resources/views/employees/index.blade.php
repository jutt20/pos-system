@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Employee Management</h2>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Add New Employee
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        All Employees
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Hire Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-3">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $employee->name }}</strong>
                                                    @if($employee->employee_id)
                                                        <br><small class="text-muted">ID: {{ $employee->employee_id }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
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
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if(!$employee->isSuperAdmin() && $employee->id !== auth()->id())
                                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this employee?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No employees found.</td>
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
</style>
@endsection
