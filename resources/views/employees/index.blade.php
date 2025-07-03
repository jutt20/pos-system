@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Employee Portal UI</h1>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('employees.index') }}">Employee Management</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customers.index') }}">Customer Management</a>
        </li>
    </ul>

    <!-- Employee Management Section -->
    <div class="content-section">
        <h2 class="section-title">Employee Management</h2>
        
        <!-- Add Employee Form -->
        <form action="{{ route('employees.store') }}" method="POST" style="margin-bottom: 30px;">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 16px; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="text" name="name" class="form-control" placeholder="Employee Name" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="email" name="email" class="form-control" placeholder="Employee Email" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <select name="roles[]" class="form-control" required>
                        <option value="">Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Manager">Manager</option>
                        <option value="Sales Agent">Sales Agent</option>
                        <option value="Accountant">Accountant</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Add Employee</button>
            </div>
            <input type="password" name="password" value="password123" style="display: none;">
            <input type="password" name="password_confirmation" value="password123" style="display: none;">
            <input type="text" name="username" value="" style="display: none;">
        </form>

        <!-- All Employees Table -->
        <h3 class="section-title">All Employees</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        @foreach($employee->roles as $role)
                            {{ $role->name }}
                        @endforeach
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('employees.edit', $employee) }}" class="btn-sm">✏️</a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm" style="background: #fee2e2; color: #991b1b; border-color: #fecaca;" onclick="return confirm('Are you sure?')">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
// Auto-generate username from email
document.querySelector('input[name="email"]').addEventListener('input', function() {
    const email = this.value;
    const username = email.split('@')[0];
    document.querySelector('input[name="username"]').value = username;
});
</script>
@endsection
