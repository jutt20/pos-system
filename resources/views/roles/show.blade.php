@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Role: {{ $role->name }}</h2>
                <div>
                    @if(!in_array($role->name, ['Super Admin']))
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-1"></i>
                            Edit Role
                        </a>
                    @endif
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Roles
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Role Information</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $role->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Guard:</strong></td>
                                    <td>{{ $role->guard_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $role->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $role->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Users Count:</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $role->users->count() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Permissions Count:</strong></td>
                                    <td>
                                        <span class="badge bg-success">{{ $role->permissions->count() }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Users with this Role</h6>
                        </div>
                        <div class="card-body">
                            @if($role->users->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($role->users as $user)
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <div>
                                                <strong>{{ $user->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                            <div>
                                                @if($user->hasRole('Super Admin'))
                                                    <span class="badge bg-danger">Super Admin</span>
                                                @elseif($user->hasRole('Admin'))
                                                    <span class="badge bg-warning">Admin</span>
                                                @else
                                                    <span class="badge bg-info">{{ $role->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">No users assigned to this role.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Permissions</h6>
                        </div>
                        <div class="card-body">
                            @if($role->name === 'Super Admin')
                                <div class="alert alert-info">
                                    <i class="fas fa-crown me-2"></i>
                                    Super Admin has access to all permissions in the system.
                                </div>
                            @elseif($role->permissions->count() > 0)
                                @php
                                    $permissionGroups = [
                                        'Employee Management' => ['manage employees'],
                                        'Customer Management' => ['manage customers'],
                                        'Invoice Management' => ['manage billing', 'manage invoices'],
                                        'Activation Management' => ['manage activations'],
                                        'Order Management' => ['manage orders'],
                                        'Report Management' => ['view reports'],
                                        'Document Management' => ['manage documents'],
                                        'System Management' => ['export data', 'system settings']
                                    ];
                                @endphp
                                
                                <div class="row">
                                    @foreach($permissionGroups as $group => $groupPermissions)
                                        @php
                                            $hasGroupPermissions = $role->permissions->whereIn('name', $groupPermissions)->count() > 0;
                                        @endphp
                                        @if($hasGroupPermissions)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <div class="card-header py-2">
                                                        <h6 class="mb-0">{{ $group }}</h6>
                                                    </div>
                                                    <div class="card-body py-2">
                                                        @foreach($groupPermissions as $permissionName)
                                                            @if($role->hasPermissionTo($permissionName))
                                                                <span class="badge bg-success me-1 mb-1">
                                                                    <i class="fas fa-check me-1"></i>
                                                                    {{ ucwords(str_replace('_', ' ', $permissionName)) }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">No permissions assigned to this role.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
