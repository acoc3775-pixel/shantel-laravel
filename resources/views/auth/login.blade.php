@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                         style="width:72px;height:72px;background:#eef3ff;color:#2563eb;">
                        <i class="bi bi-box-arrow-in-right fs-2"></i>
                    </div>
                    <h1 class="fw-bold mb-1">Welcome Back</h1>
                    <p class="text-muted mb-0">Sign in to manage reservations.</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <i class="bi bi-x-circle-fill me-1"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ secure_url(route('login.post', [], false)) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="you@example.com"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Enter your password"
                                required
                            >
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label class="form-check-label small">
                            <input type="checkbox" name="remember" value="1" class="form-check-input me-1">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Login
                    </button>
                </form>

                <div class="text-center mt-4 small text-muted">
                    Don’t have an account?
                    <a href="{{ secure_url(route('register', [], false)) }}" class="fw-semibold text-decoration-none">
                        Create one
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection