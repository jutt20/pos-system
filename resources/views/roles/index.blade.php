@extends('layouts.app')

@section('title', 'Role Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Role Management</h2>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Role
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Users Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>
                                <strong>{{ $role->name }}</strong>
                                @if($role->name === 'Super Admin')
                                    <span class="badge bg-danger ms-2">System Role</span>
                                @endif
                            </td>
                            <td>
                                @foreach($role->permissions->take(3) as $permission)
                                    <span class="badge bg-secondary me-1">{{ $permission->name }}</span>
                                @endforeach
                                @if($role->permissions->count() > 3)
                                    <span class="badge bg-light text-dark">+{{ $role->permissions->count() - 3 }} more</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $role->users->count() }} users</span>
                            </td>
                            <td>{{ $role->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($role->name !== 'Super Admin')
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
