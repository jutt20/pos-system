@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Profile Settings</h1>
    </div>

    <div class="content-section">
        <h2 class="section-title">Update Profile Information</h2>
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone</label>
                <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-primary">Save Changes</button>
                @if (session('status') === 'profile-updated')
                    <span class="text-success">Saved successfully!</span>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
