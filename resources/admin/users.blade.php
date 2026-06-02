@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Users Management</h1>
        <p class="page-subtitle">Manage registered users and admin access.</p>
    </div>

    <a href="{{ secure_url(route('admin.dashboard', [], false)) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Dashboard
    </a>
</div>

<div class="table-wrapper">
    <table class="res-table">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $i => $user)
                <tr>
                    <td class="col-id">{{ $users->firstItem() + $i }}</td>

                    <td>
                        <div class="user-inline">
                            <div class="avatar-placeholder-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <div class="guest-name">{{ $user->name }}</div>
                        </div>
                    </td>

                    <td>
                        <div class="guest-email">{{ $user->email }}</div>
                    </td>

                    <td>
                        <span class="badge {{ $user->is_admin ? 'badge-confirmed' : 'badge-pending' }}">
                            <i class="bi {{ $user->is_admin ? 'bi-shield-check' : 'bi-person' }}"></i>
                            {{ $user->is_admin ? 'Admin' : 'Member' }}
                        </span>
                    </td>

                    <td>
                        <div class="res-date">{{ $user->created_at->format('M d, Y') }}</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h3>No users found</h3>
                            <p>Registered users will appear here.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
    <div class="pagination-wrap">
        {{ $users->links() }}
    </div>
@endif

@endsection