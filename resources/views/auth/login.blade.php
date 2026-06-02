@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="auth-shell">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="bi bi-box-arrow-in-right"></i>
            </div>
            <h1>Welcome Back</h1>
            <p>Sign in to manage reservations.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <i class="bi bi-x-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ secure_url(route('login.post', [], false)) }}">
            @csrf

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
                    autofocus
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="input-field"
                    placeholder="Enter your password"
                    required
                >
            </div>

            <label class="remember-row">
                <input type="checkbox" name="remember" value="1">
                <span>Remember me</span>
            </label>

            <button type="submit" class="btn btn-primary auth-btn">
                <i class="bi bi-box-arrow-in-right"></i>
                Login
            </button>
        </form>

        <div class="auth-footer">
            Don’t have an account?
            <a href="{{ secure_url(route('register', [], false)) }}">Create one</a>
        </div>
    </div>
</div>

@endsection