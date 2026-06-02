@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Admin Dashboard</h1>
        <p class="page-subtitle">Platform overview and reservation activity.</p>
    </div>

    <a href="{{ secure_url(route('admin.users', [], false)) }}" class="btn btn-primary">
        <i class="bi bi-people-fill"></i>
        Manage Users
    </a>
</div>

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-people-fill"></i>
        </div>
        <span class="stat-number">{{ $stats['users'] }}</span>
        <span class="stat-label">Users</span>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-calendar-check"></i>
        </div>
        <span class="stat-number">{{ $stats['reservations'] }}</span>
        <span class="stat-label">Reservations</span>
    </div>

    <div class="stat-card stat-pending">
        <div class="stat-icon">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <span class="stat-number">{{ $stats['pending'] }}</span>
        <span class="stat-label">Pending</span>
    </div>

    <div class="stat-card stat-confirmed">
        <div class="stat-icon">
            <i class="bi bi-check-circle"></i>
        </div>
        <span class="stat-number">{{ $stats['confirmed'] }}</span>
        <span class="stat-label">Confirmed</span>
    </div>

    <div class="stat-card stat-cancelled">
        <div class="stat-icon">
            <i class="bi bi-x-circle"></i>
        </div>
        <span class="stat-number">{{ $stats['cancelled'] }}</span>
        <span class="stat-label">Cancelled</span>
    </div>
</div>

<div class="admin-grid">
    <div class="card">
        <div class="card-header">
            <i class="bi bi-clock-history"></i>
            Recent Reservations
        </div>

        <div class="card-body">
            @if($recentReservations->isEmpty())
                <div class="empty-state compact">
                    <div class="empty-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3>No reservations yet</h3>
                    <p>Reservations will appear here once users create them.</p>
                </div>
            @else
                <div class="mini-list">
                    @foreach($recentReservations as $reservation)
                        <div class="mini-item">
                            <div>
                                <div class="mini-title">{{ $reservation->full_name }}</div>
                                <div class="mini-sub">
                                    {{ $reservation->email }} ·
                                    {{ $reservation->reservation_date->format('M d, Y') }}
                                </div>
                            </div>

                            <span class="badge {{ $reservation->status_badge }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-person-lines-fill"></i>
            Recent Users
        </div>

        <div class="card-body">
            @if($recentUsers->isEmpty())
                <div class="empty-state compact">
                    <div class="empty-icon">
                        <i class="bi bi-person-x"></i>
                    </div>
                    <h3>No users yet</h3>
                    <p>Registered users will appear here.</p>
                </div>
            @else
                <div class="mini-list">
                    @foreach($recentUsers as $user)
                        <div class="mini-item">
                            <div class="user-inline">
                                <div class="avatar-placeholder-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="mini-title">{{ $user->name }}</div>
                                    <div class="mini-sub">{{ $user->email }}</div>
                                </div>
                            </div>

                            <span class="badge {{ $user->is_admin ? 'badge-confirmed' : 'badge-pending' }}">
                                {{ $user->is_admin ? 'Admin' : 'Member' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection