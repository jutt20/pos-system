@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Role: {{ $role->name }}
                    </h5>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Roles
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $role->name) }}"
                                           {{ in_array($role->name, ['Super Admin', 'Admin']) ? 'readonly' : '' }}>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="guard_name" class="form-label">Guard</label>
                                    <select class="form-control @error('guard_name') is-invalid @enderror" 
                                            id="guard_name" 
                                            name="guard_name"
                                            {{ in_array($role->name, ['Super Admin', 'Admin']) ? 'disabled' : '' }}>
                                        <option value="web" {{ old('guard_name', $role->guard_name) == 'web' ? 'selected' : '' }}>Web</option>
                                        <option value="api" {{ old('guard_name', $role->guard_name) == 'api' ? 'selected' : '' }}>API</option>
                                    </select>
                                    @error('guard_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label">Permissions</label>
                            @if(in_array($role->name, ['Super Admin']))
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Super Admin has all permissions by default and cannot be modified.
                                </div>
                            @else
                                <div class="row">
                                    @php
                                        $permissionGroups = [
                                            'Employee Management' => ['manage employees', 'view employees', 'create employees', 'edit employees', 'delete employees'],
                                            'Customer Management' => ['manage customers', 'view customers', 'create customers', 'edit customers', 'delete customers'],
                                            'Invoice Management' => ['manage invoices', 'view invoices', 'create invoices', 'edit invoices', 'delete invoices'],
                                            'Activation Management' => ['manage activations', 'view activations', 'create activations', 'edit activations', 'delete activations'],
                                            'Order Management' => ['manage orders', 'view orders', 'create orders', 'edit orders', 'delete orders'],
                                            'Report Management' => ['view reports', 'export reports', 'manage reports'],
                                            'System Management' => ['manage roles', 'manage permissions', 'view system logs']
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
                                                                <input class="form-check-input" 
                                                                       type="checkbox" 
                                                                       name="permissions[]" 
                                                                       value="{{ $permission->id }}"
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
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Update Role
                            </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary ms-2">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
