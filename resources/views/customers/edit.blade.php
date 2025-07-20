@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Edit Customer</h1>
    </div>

    <div class="content-section">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="name" class="form-label">Customer Name *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                    @error('phone')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" id="company" name="company" class="form-control" value="{{ old('company', $customer->company) }}">
                    @error('company')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control" rows="3">{{ old('address', $customer->address) }}</textarea>
                @error('address')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="balance" class="form-label">Balance</label>
                    <input type="number" step="0.01" id="balance" name="balance" class="form-control" value="{{ old('balance', $customer->balance) }}">
                    @error('balance')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prepaid_status" class="form-label">Payment Type *</label>
                    <select id="prepaid_status" name="prepaid_status" class="form-control" required>
                        <option value="postpaid" {{ old('prepaid_status', $customer->prepaid_status) == 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                        <option value="prepaid" {{ old('prepaid_status', $customer->prepaid_status) == 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                    </select>
                    @error('prepaid_status')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="assigned_employee_id" class="form-label">Assign to Employee</label>
                    <select id="assigned_employee_id" name="assigned_employee_id" class="form-control">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('assigned_employee_id', $customer->assigned_employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_employee_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-primary">Update Customer</button>
                <a href="{{ route('customers.index') }}" class="btn-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
