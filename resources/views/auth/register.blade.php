@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                         style="width:72px;height:72px;background:#eef3ff;color:#2563eb;">
                        <i class="bi bi-person-plus fs-2"></i>
                    </div>
                    <h1 class="fw-bold mb-1">Create Account</h1>
                    <p class="text-muted mb-0">Sign up to start managing reservations.</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <i class="bi bi-x-circle-fill me-1"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ secure_url(route('register.post', [], false)) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-person"></i>
                            </span>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control"
                                placeholder="Your full name"
                                required
                                autofocus
                            >
                        </div>
                    </div>

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
                                placeholder="Minimum 8 characters"
                                required
                            >
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Repeat password"
                                required
                            >
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-person-plus me-1"></i>
                        Register
                    </button>
                </form>

                <div class="text-center mt-4 small text-muted">
                    Already have an account?
                    <a href="{{ secure_url(route('login', [], false)) }}" class="fw-semibold text-decoration-none">
                        Login here
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection