@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Employee Details: {{ $employee->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Personal Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $employee->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $employee->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Username:</strong></td>
                                    <td>{{ $employee->username }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $employee->phone ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Joined:</strong></td>
                                    <td>{{ $employee->created_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Roles & Permissions</h6>
                            <div class="mb-3">
                                @foreach($employee->roles as $role)
                                    <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                @endforeach
                            </div>
                            
                            <h6>Direct Permissions</h6>
                            <div class="mb-3">
                                @foreach($employee->getDirectPermissions() as $permission)
                                    <span class="badge bg-secondary me-1">{{ $permission->name }}</span>
                                @endforeach
                                @if($employee->getDirectPermissions()->isEmpty())
                                    <small class="text-muted">No direct permissions assigned</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary">{{ $employee->assignedCustomers->count() }}</h4>
                            <small>Assigned Customers</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $employee->invoices->count() }}</h4>
                            <small>Created Invoices</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-info">{{ $employee->activations->count() }}</h4>
                            <small>Activations</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning">{{ $employee->simOrders->count() }}</h4>
                            <small>SIM Orders</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Employee
                        </a>
                        @if(!$employee->isSuperAdmin())
                        <form action="{{ route('employees.destroy', $employee) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Are you sure you want to delete this employee?')">
                                <i class="fas fa-trash"></i> Delete Employee
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
