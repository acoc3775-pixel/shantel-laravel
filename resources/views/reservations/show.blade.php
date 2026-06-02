@extends('layouts.app')

@section('title', 'Reservation Details')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Reservation Details</h1>
        <p class="text-muted mb-0">View guest and booking information.</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ secure_url(route('reservations.edit', $reservation, false)) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>
            Edit
        </a>

        <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="btn btn-light border shadow-sm">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body text-center p-4">
                <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                     style="width:96px;height:96px;background:#eef3ff;color:#2563eb;font-size:2.5rem;font-weight:700;">
                    {{ strtoupper(substr($reservation->full_name, 0, 1)) }}
                </div>

                <h4 class="fw-bold mb-1">{{ $reservation->full_name }}</h4>
                <p class="text-muted mb-3">{{ $reservation->email }}</p>

                <span class="badge rounded-pill px-3 py-2
                    @if($reservation->status === 'confirmed') text-bg-success
                    @elseif($reservation->status === 'cancelled') text-bg-danger
                    @else text-bg-warning
                    @endif">
                    {{ ucfirst($reservation->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4 pb-0">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-info-circle text-primary me-1"></i>
                    Booking Information
                </h4>
                <p class="text-muted mb-0">Complete reservation record.</p>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small fw-semibold text-uppercase">Date</div>
                            <div class="fw-bold">{{ $reservation->reservation_date->format('M d, Y') }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small fw-semibold text-uppercase">Time</div>
                            <div class="fw-bold">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small fw-semibold text-uppercase">Party Size</div>
                            <div class="fw-bold">{{ $reservation->party_size }} pax</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small fw-semibold text-uppercase">Purpose</div>
                            <div class="fw-bold">{{ $reservation->purpose ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex flex-wrap justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteReservationModal">
                        <i class="bi bi-trash3 me-1"></i>
                        Delete
                    </button>

                    <a href="{{ secure_url(route('reservations.edit', $reservation, false)) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Edit Reservation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteReservationModal" tabindex="-1" aria-hidden="true">
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
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>

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

@endsection