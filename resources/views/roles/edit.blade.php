@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Edit Role: {{ $role->name }}</h2>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Back to Roles
                </a>
            </div>

            @if($role->name === 'Super Admin')
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Warning:</strong> Super Admin role cannot be modified as it has system-level access.
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Role Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $role->name) }}" 
                                           {{ $role->name === 'Super Admin' ? 'readonly' : '' }} required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($role->name !== 'Super Admin')
                        <div class="mb-4">
                            <label class="form-label">Permissions</label>
                            <div class="row">
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

                                @foreach($permissionGroups as $group => $groupPermissions)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0">{{ $group }}</h6>
                                        </div>
                                        <div class="card-body py-2">
                                            @foreach($groupPermissions as $permissionName)
                                                @php
                                                    $permission = $permissions->firstWhere('name', $permissionName);
                                                @endphp
                                                @if($permission)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                           value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
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
                        @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Super Admin has all permissions by default and cannot be modified.
                        </div>
                        @endif

                        @if($role->name !== 'Super Admin')
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Update Role
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
