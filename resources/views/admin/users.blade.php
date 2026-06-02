@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Users Management</h1>
        <p class="text-muted mb-0">Manage registered users and admin access.</p>
    </div>

    <a href="{{ secure_url(route('admin.dashboard', [], false)) }}" class="btn btn-light border shadow-sm">
        <i class="bi bi-arrow-left me-1"></i>
        Dashboard
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:42px;height:42px;background:#eef3ff;color:#2563eb;">
                <i class="bi bi-people-fill fs-5"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0">All Users</h5>
                <p class="text-muted small mb-0">Registered accounts in the system.</p>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:80px">#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $i => $user)
                    <tr>
                        <td class="text-muted">
                            {{ $users->firstItem() + $i }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:38px;height:38px;background:#eef3ff;color:#2563eb;font-weight:700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>

                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <div class="text-muted small">ID #{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="text-muted">{{ $user->email }}</span>
                        </td>

                        <td>
                            <span class="badge rounded-pill {{ $user->is_admin ? 'text-bg-primary' : 'text-bg-secondary' }}">
                                <i class="bi {{ $user->is_admin ? 'bi-shield-check' : 'bi-person' }} me-1"></i>
                                {{ $user->is_admin ? 'Admin' : 'Member' }}
                            </span>
                        </td>

                        <td>
                            <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                <h5 class="fw-bold">No users found</h5>
                                <p class="mb-0">Registered users will appear here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="card-footer bg-white border-0 p-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection