@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Role: {{ $role->name }}</h2>
                <div class="btn-group">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Roles
                    </a>
                    @if($role->name !== 'Super Admin')
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit Role
                    </a>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Role Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Role Name</h6>
                                    <p class="fs-5">{{ $role->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Created</h6>
                                    <p>{{ $role->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Permissions</h5>
                        </div>
                        <div class="card-body">
                            @if($role->name === 'Super Admin')
                                <div class="alert alert-info">
                                    <i class="fas fa-crown me-2"></i>
                                    <strong>Super Admin</strong> has all system permissions by default.
                                </div>
                            @else
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
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header py-2">
                                                <h6 class="mb-0">{{ $group }}</h6>
                                            </div>
                                            <div class="card-body py-2">
                                                @foreach($groupPermissions as $permissionName)
                                                    @if($role->permissions->where('name', $permissionName)->count() > 0)
                                                        <span class="badge bg-success me-1 mb-1">
                                                            <i class="fas fa-check me-1"></i>
                                                            {{ ucwords(str_replace('_', ' ', $permissionName)) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-light text-dark me-1 mb-1">
                                                            <i class="fas fa-times me-1"></i>
                                                            {{ ucwords(str_replace('_', ' ', $permissionName)) }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <h3 class="text-primary">{{ $role->users->count() }}</h3>
                                    <p class="text-muted mb-0">Users</p>
                                </div>
                                <div class="col-6">
                                    <h3 class="text-success">{{ $role->permissions->count() }}</h3>
                                    <p class="text-muted mb-0">Permissions</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Users with this Role</h5>
                        </div>
                        <div class="card-body">
                            @forelse($role->users as $user)
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar-circle me-2">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $user->name }}</strong><br>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No users assigned to this role.</p>
                            @endforelse
                        </div>
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
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}
</style>
@endsection
