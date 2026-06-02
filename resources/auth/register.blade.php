@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="auth-shell">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h1>Create Account</h1>
            <p>Sign up to start managing reservations.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <i class="bi bi-x-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ secure_url(route('register.post', [], false)) }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="input-field"
                    placeholder="Your Name"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="input-field"
                    placeholder="you@example.com"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="input-field"
                    placeholder="Enter a password"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="input-field"
                    placeholder="Confirm password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary auth-btn">
                <i class="bi bi-person-plus-fill"></i>
                Register
            </button>
        </form>

        <div class="auth-footer">
            Already have an account?
            <a href="{{ secure_url(route('login', [], false)) }}">Login here</a>
        </div>
    </div>
</div>

@endsection