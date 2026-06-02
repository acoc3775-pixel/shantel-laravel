@extends('layouts.app')

@section('title', $isAdmin ? 'All Reservations' : 'My Reservations')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">{{ $isAdmin ? 'All Reservations' : 'My Reservations' }}</h1>
        <p class="text-muted mb-0">
            {{ $isAdmin ? 'Manage all user bookings and update their status.' : 'View your booking history and current reservation status.' }}
        </p>
    </div>

    @unless($isAdmin)
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReservationModal">
            <i class="bi bi-plus-lg me-1"></i>
            Add Booking
        </button>
    @endunless
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
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name, email, or purpose..."
                           class="form-control">
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
                {{ $isAdmin ? 'No booking records yet.' : 'You have not submitted any booking yet.' }}
            </p>

            @unless($isAdmin)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReservationModal">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add Booking
                </button>
            @endunless
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px">#</th>
                        <th>Guest</th>
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
                                @if($isAdmin)
                                    <form method="POST"
                                          action="{{ secure_url(route('reservations.updateStatus', $reservation, false)) }}"
                                          class="d-flex gap-2 align-items-center">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status" class="form-select form-select-sm" style="min-width:130px">
                                            <option value="pending" @selected($reservation->status === 'pending')>Pending</option>
                                            <option value="confirmed" @selected($reservation->status === 'confirmed')>Confirmed</option>
                                            <option value="cancelled" @selected($reservation->status === 'cancelled')>Cancelled</option>
                                        </select>

                                        <button type="submit" class="btn btn-sm btn-light border" title="Update status">
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="badge rounded-pill
                                        @if($reservation->status === 'confirmed') text-bg-success
                                        @elseif($reservation->status === 'cancelled') text-bg-danger
                                        @else text-bg-warning
                                        @endif">
                                        <i class="bi
                                            @if($reservation->status === 'confirmed') bi-check-circle
                                            @elseif($reservation->status === 'cancelled') bi-x-circle
                                            @else bi-hourglass-split
                                            @endif me-1"></i>
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button type="button"
                                            class="btn btn-light border"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewReservationModal{{ $reservation->id }}"
                                            title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    @unless($isAdmin)
                                        <button type="button"
                                                class="btn btn-light border"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editReservationModal{{ $reservation->id }}"
                                                title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    @endunless

                                    <button type="button"
                                            class="btn btn-light border text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteReservationModal{{ $reservation->id }}"
                                            title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- View Modal --}}
                        <div class="modal fade" id="viewReservationModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow">
                                    <div class="modal-header border-0 pb-0">
                                        <div>
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-eye text-primary me-1"></i>
                                                Reservation Details
                                            </h5>
                                            <p class="text-muted small mb-0">Booking information and status.</p>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="rounded-4 p-3 bg-light mb-3">
                                            <div class="fw-bold">{{ $reservation->full_name }}</div>
                                            <div class="text-muted small">{{ $reservation->email }}</div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="small text-muted">Date</div>
                                                <div class="fw-semibold">{{ $reservation->reservation_date->format('M d, Y') }}</div>
                                            </div>

                                            <div class="col-6">
                                                <div class="small text-muted">Time</div>
                                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}</div>
                                            </div>

                                            <div class="col-6">
                                                <div class="small text-muted">Party</div>
                                                <div class="fw-semibold">{{ $reservation->party_size }} pax</div>
                                            </div>

                                            <div class="col-6">
                                                <div class="small text-muted">Status</div>
                                                <div class="fw-semibold">{{ ucfirst($reservation->status) }}</div>
                                            </div>

                                            <div class="col-12">
                                                <div class="small text-muted">Purpose</div>
                                                <div class="fw-semibold">{{ $reservation->purpose ?? '—' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Modal --}}
                        @unless($isAdmin)
                            <div class="modal fade" id="editReservationModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <div>
                                                <h5 class="modal-title fw-bold">
                                                    <i class="bi bi-pencil-square text-primary me-1"></i>
                                                    Edit Booking
                                                </h5>
                                                <p class="text-muted small mb-0">You cannot change the status. Admin will update it.</p>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form method="POST" action="{{ secure_url(route('reservations.update', $reservation, false)) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                @include('reservations.partials.form-fields', ['reservation' => $reservation])
                                            </div>

                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-check2-circle me-1"></i>
                                                    Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endunless

                        {{-- Delete Modal --}}
                        <div class="modal fade" id="deleteReservationModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4 shadow">
                                    <div class="modal-header border-0 pb-0">
                                        <div>
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-trash3 text-danger me-1"></i>
                                                Delete Reservation?
                                            </h5>
                                            <p class="text-muted small mb-0">This action cannot be undone.</p>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="rounded-4 p-3 bg-light">
                                            <div class="fw-bold">{{ $reservation->full_name }}</div>
                                            <div class="text-muted small">{{ $reservation->email }}</div>
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

{{-- Add Modal --}}
@unless($isAdmin)
    <div class="modal fade" id="addReservationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-calendar-plus text-primary me-1"></i>
                            Add Booking
                        </h5>
                        <p class="text-muted small mb-0">New bookings are automatically set to pending.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ secure_url(route('reservations.store', [], false)) }}">
                    @csrf

                    <div class="modal-body">
                        @include('reservations.partials.form-fields', ['reservation' => null])
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>
                            Submit Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endunless

@endsection