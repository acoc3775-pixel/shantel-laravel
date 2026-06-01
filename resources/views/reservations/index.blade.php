@extends('layouts.app')

@section('title', 'Reservation List')

@section('content')

{{-- ── Page Header ──────────────────────────────────────────── --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Reservations</h1>
        <p class="page-subtitle">Manage all your bookings in one place.</p>
    </div>

    <a href="{{ secure_url(route('reservations.create', [], false)) }}" class="btn btn-primary">
        + Add Reservation
    </a>
</div>

{{-- ── Stats Cards ──────────────────────────────────────────── --}}
<div class="stats-row">
    <div class="stat-card">
        <span class="stat-number">{{ $stats['total'] }}</span>
        <span class="stat-label">Total</span>
    </div>

    <div class="stat-card stat-pending">
        <span class="stat-number">{{ $stats['pending'] }}</span>
        <span class="stat-label">Pending</span>
    </div>

    <div class="stat-card stat-confirmed">
        <span class="stat-number">{{ $stats['confirmed'] }}</span>
        <span class="stat-label">Confirmed</span>
    </div>

    <div class="stat-card stat-cancelled">
        <span class="stat-number">{{ $stats['cancelled'] }}</span>
        <span class="stat-label">Cancelled</span>
    </div>
</div>

{{-- ── Filters & Search ─────────────────────────────────────── --}}
<form method="GET" action="{{ secure_url(route('reservations.index', [], false)) }}" class="filter-bar">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search by name or email..."
        class="input-field"
    >

    <select name="status" class="input-field select-field">
        <option value="">All Statuses</option>
        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
        <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmed</option>
        <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
    </select>

    <button type="submit" class="btn btn-secondary">Filter</button>

    @if(request('search') || request('status'))
        <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="btn btn-ghost">
            Clear
        </a>
    @endif
</form>

{{-- ── Reservation Table ────────────────────────────────────── --}}
@if($reservations->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">🗓️</div>
        <h3>No reservations found</h3>
        <p>
            Try a different filter, or
            <a href="{{ secure_url(route('reservations.create', [], false)) }}">
                add a new one
            </a>.
        </p>
    </div>
@else
    <div class="table-wrapper">
        <table class="res-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Date & Time</th>
                    <th>Party</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td class="col-id">{{ $reservation->id }}</td>

                        <td>
                            <div class="guest-name">{{ $reservation->full_name }}</div>
                            <div class="guest-email">{{ $reservation->email }}</div>
                        </td>

                        <td>
                            <div class="res-date">
                                {{ $reservation->reservation_date->format('M d, Y') }}
                            </div>
                            <div class="res-time">
                                {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}
                            </div>
                        </td>

                        <td>{{ $reservation->party_size }} pax</td>

                        <td>{{ $reservation->purpose ?? '—' }}</td>

                        <td>
                            <span class="badge {{ $reservation->status_badge }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="action-group">
                                {{-- View --}}
                                <a href="{{ secure_url(route('reservations.show', $reservation, false)) }}"
                                   class="btn-icon"
                                   title="View">
                                    👁
                                </a>

                                {{-- Edit --}}
                                <a href="{{ secure_url(route('reservations.edit', $reservation, false)) }}"
                                   class="btn-icon"
                                   title="Edit">
                                    ✏️
                                </a>

                                {{-- Delete --}}
                                <form method="POST"
                                      action="{{ secure_url(route('reservations.destroy', $reservation, false)) }}"
                                      onsubmit="return confirm('Delete this reservation?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-icon btn-danger" title="Delete">
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrap">
        {{ $reservations->links() }}
    </div>
@endif

@endsection