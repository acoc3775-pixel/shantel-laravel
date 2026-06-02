@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="container py-4">
    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">My Profile</h1>
            <p class="page-subtitle mb-0">Update your account information and password.</p>
        </div>

        <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="btn btn-light border shadow-sm">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger shadow-sm border-0 rounded-4 mb-4">
            <div class="d-flex gap-2">
                <i class="bi bi-x-circle-fill"></i>
                <div>
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        {{-- Profile Summary --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body text-center p-4">
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                         style="width:96px;height:96px;background:#eef3ff;color:#2563eb;font-size:2.5rem;font-weight:700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <span class="badge {{ $user->is_admin ? 'text-bg-primary' : 'text-bg-secondary' }} px-3 py-2 rounded-pill">
                        <i class="bi {{ $user->is_admin ? 'bi-shield-check' : 'bi-person' }} me-1"></i>
                        {{ $user->is_admin ? 'Administrator' : 'Member' }}
                    </span>

                    <hr class="my-4">

                    <div class="text-start small text-muted">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Account ID</span>
                            <strong>#{{ $user->id }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Joined</span>
                            <strong>{{ $user->created_at?->format('M d, Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Form --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;background:#eef3ff;color:#2563eb;">
                            <i class="bi bi-person-gear fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">Account Settings</h3>
                            <p class="text-muted mb-0">Edit your profile details below.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form id="profileUpdateForm" method="POST" action="{{ secure_url(route('profile.update', [], false)) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="form-control"
                                        placeholder="Enter your full name"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="form-control"
                                        placeholder="you@example.com"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="my-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-lock text-primary"></i>
                                <h5 class="fw-bold mb-0">Change Password</h5>
                            </div>
                            <p class="text-muted small mb-0">
                                Leave password fields blank if you do not want to change your password.
                            </p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-key"></i>
                                    </span>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Minimum 8 characters"
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-key-fill"></i>
                                    </span>
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        placeholder="Repeat new password"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                            <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="btn btn-light border">
                                Cancel
                            </a>

                            <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#confirmUpdateModal">
                                <i class="bi bi-check2-circle me-1"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Security Note --}}
            <div class="alert alert-light border shadow-sm rounded-4 mt-4 mb-0">
                <div class="d-flex gap-2">
                    <i class="bi bi-info-circle text-primary"></i>
                    <div class="small text-muted">
                        Password changes are optional. Your current session stays active after saving profile updates.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Confirm Update Modal --}}
<div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" id="confirmUpdateModalLabel">
                        <i class="bi bi-person-check text-primary me-1"></i>
                        Save Profile Changes?
                    </h5>
                    <p class="text-muted small mb-0">Please confirm before updating your account.</p>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="rounded-4 p-3" style="background:#f8fafc;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;background:#eef3ff;color:#2563eb;font-weight:700;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold">{{ $user->name }}</div>
                            <div class="text-muted small">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <p class="text-muted small mt-3 mb-0">
                    Your name, email, and password will be updated based on the fields you changed.
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button type="submit" form="profileUpdateForm" class="btn btn-primary px-4">
                    <i class="bi bi-check2-circle me-1"></i>
                    Confirm Save
                </button>
            </div>
        </div>
    </div>
</div>

@endsection