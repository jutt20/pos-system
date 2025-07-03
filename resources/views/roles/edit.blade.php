@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Edit Role: {{ $role->name }}</h2>
                <div>
                    <a href="{{ route('roles.show', $role) }}" class="btn btn-secondary me-2">
                        <i class="fas fa-eye me-1"></i>
                        View Role
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Roles
                    </a>
                </div>
            </div>

            @if($role->name === 'Super Admin')
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Super Admin role cannot be modified as it has full system access.
                </div>
                <div class="text-center">
                    <a href="{{ route('roles.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Roles
                    </a>
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Edit Role Permissions
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.update', $role) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Role Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $role->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h6 class="mb-3">Assign Permissions</h6>
                                    
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
                                            <div class="col-md-6 mb-4">
                                                <div class="card">
                                                    <div class="card-header py-2">
                                                        <h6 class="mb-0">{{ $group }}</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach($groupPermissions as $permissionName)
                                                            @php
                                                                $permission = $permissions->where('name', $permissionName)->first();
                                                            @endphp
                                                            @if($permission)
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox" 
                                                                           name="permissions[]" value="{{ $permission->id }}"
                                                                           id="permission_{{ $permission->id }}"
                                                                           {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                        {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Update Role
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
