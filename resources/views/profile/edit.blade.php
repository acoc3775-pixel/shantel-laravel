@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">My Profile</h1>
        <p class="page-subtitle">Update your account information and password.</p>
    </div>

    <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
</div>

<div class="auth-shell">
    <div class="auth-card profile-edit-card">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <h1>Account Settings</h1>
            <p>Keep your profile details updated.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <i class="bi bi-x-circle-fill"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ secure_url(route('profile.update', [], false)) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="input-field"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="input-field"
                    required
                >
            </div>

            <div class="divider-label">Change Password</div>

            <p class="form-hint">
                Leave password fields blank if you do not want to change your password.
            </p>

            <div class="form-group">
                <label class="form-label" for="password">New Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="input-field"
                    placeholder="Minimum 8 characters"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="input-field"
                    placeholder="Repeat new password"
                >
            </div>

            <button type="submit" class="btn btn-primary auth-btn">
                <i class="bi bi-check2-circle"></i>
                Save Changes
            </button>
        </form>
    </div>
</div>

@endsection