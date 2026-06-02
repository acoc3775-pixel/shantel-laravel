@extends('layouts.app')

@section('title', 'Reservation List')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Reservations</h1>
        <p class="text-muted mb-0">Manage all your bookings in one place.</p>
    </div>

    <a href="{{ secure_url(route('reservations.create', [], false)) }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        Add Reservation
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total</div>
                    <div class="fs-2 fw-bold">{{ $stats['total'] }}</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#eef3ff;color:#2563eb;">
                    <i class="bi bi-list-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Pending</div>
                    <div class="fs-2 fw-bold">{{ $stats['pending'] }}</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#fff7ed;color:#f97316;">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Confirmed</div>
                    <div class="fs-2 fw-bold">{{ $stats['confirmed'] }}</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#ecfdf5;color:#22c55e;">
                    <i class="bi bi-check-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Cancelled</div>
                    <div class="fs-2 fw-bold">{{ $stats['cancelled'] }}</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#fef2f2;color:#ef4444;">
                    <i class="bi bi-x-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ secure_url(route('reservations.index', [], false)) }}" class="row g-2 align-items-center">
            <div class="col-md">
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-search"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name or email..."
                        class="form-control"
                    >
                </div>
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmed</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                </select>
            </div>

            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-1"></i>
                    Filter
                </button>
            </div>

            @if(request('search') || request('status'))
                <div class="col-md-auto">
                    <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="btn btn-light border">
                        <i class="bi bi-x-lg me-1"></i>
                        Clear
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

@if($reservations->isEmpty())
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center text-muted py-5">
            <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
            <h4 class="fw-bold">No reservations found</h4>
            <p class="mb-3">
                Try a different filter, or add a new reservation.
            </p>
            <a href="{{ secure_url(route('reservations.create', [], false)) }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add Reservation
            </a>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px">#</th>
                        <th>Name</th>
                        <th>Date & Time</th>
                        <th>Party</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td class="text-muted">#{{ $reservation->id }}</td>

                            <td>
                                <div class="fw-semibold">{{ $reservation->full_name }}</div>
                                <div class="text-muted small">{{ $reservation->email }}</div>
                            </td>

                            <td>
                                <div class="fw-semibold">{{ $reservation->reservation_date->format('M d, Y') }}</div>
                                <div class="text-muted small">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}
                                </div>
                            </td>

                            <td>{{ $reservation->party_size }} pax</td>

                            <td>{{ $reservation->purpose ?? '—' }}</td>

                            <td>
                                <span class="badge rounded-pill
                                    @if($reservation->status === 'confirmed') text-bg-success
                                    @elseif($reservation->status === 'cancelled') text-bg-danger
                                    @else text-bg-warning
                                    @endif">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>

                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ secure_url(route('reservations.show', $reservation, false)) }}"
                                       class="btn btn-light border"
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ secure_url(route('reservations.edit', $reservation, false)) }}"
                                       class="btn btn-light border"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-light border text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteReservationModal{{ $reservation->id }}"
                                            title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>

                                <div class="modal fade" id="deleteReservationModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="deleteReservationModalLabel{{ $reservation->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4 shadow">
                                            <div class="modal-header border-0 pb-0">
                                                <div>
                                                    <h5 class="modal-title fw-bold" id="deleteReservationModalLabel{{ $reservation->id }}">
                                                        <i class="bi bi-trash3 text-danger me-1"></i>
                                                        Delete Reservation?
                                                    </h5>
                                                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body text-start">
                                                <div class="rounded-4 p-3 bg-light">
                                                    <div class="fw-bold">{{ $reservation->full_name }}</div>
                                                    <div class="text-muted small">{{ $reservation->email }}</div>
                                                    <div class="text-muted small">
                                                        {{ $reservation->reservation_date->format('M d, Y') }}
                                                        at
                                                        {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <form method="POST" action="{{ secure_url(route('reservations.destroy', $reservation, false)) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="bi bi-trash3 me-1"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($reservations->hasPages())
            <div class="card-footer bg-white border-0 p-3">
                {{ $reservations->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endif

@endsection