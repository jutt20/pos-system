@extends('layouts.app')

@section('title', 'Roles & Permissions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Roles & Permissions</h2>
                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Create New Role
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-shield me-2"></i>
                        System Roles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Users</th>
                                    <th>Permissions</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($role->name === 'Super Admin')
                                                    <i class="fas fa-crown text-warning me-2"></i>
                                                @elseif($role->name === 'Admin')
                                                    <i class="fas fa-user-shield text-danger me-2"></i>
                                                @else
                                                    <i class="fas fa-user text-primary me-2"></i>
                                                @endif
                                                <strong>{{ $role->name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $role->users->count() }}</span>
                                        </td>
                                        <td>
                                            @if($role->name === 'Super Admin')
                                                <span class="badge bg-success">All Permissions</span>
                                            @else
                                                <span class="badge bg-info">{{ $role->permissions->count() }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $role->created_at->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!in_array($role->name, ['Super Admin']))
                                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this role?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No roles found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Role Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end">
                                        <h4 class="text-primary">{{ $roles->count() }}</h4>
                                        <small class="text-muted">Total Roles</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <h4 class="text-success">{{ $totalUsers }}</h4>
                                        <small class="text-muted">Total Users</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-info">{{ $totalPermissions }}</h4>
                                    <small class="text-muted">Permissions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Available Permissions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($permissions as $permission)
                                    <span class="badge bg-light text-dark">{{ $permission->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
