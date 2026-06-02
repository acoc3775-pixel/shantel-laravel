@extends('layouts.app')

@section('title', 'Add Reservation')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Add Reservation</h1>
        <p class="text-muted mb-0">Create a new booking record.</p>
    </div>

    <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="btn btn-light border shadow-sm">
        <i class="bi bi-arrow-left me-1"></i>
        Back
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4">
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

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 p-4 pb-0">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:48px;height:48px;background:#eef3ff;color:#2563eb;">
                <i class="bi bi-calendar-plus fs-4"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-1">Reservation Details</h4>
                <p class="text-muted mb-0">Fill out the guest and booking information.</p>
            </div>
        </div>
    </div>

    <div class="card-body p-4">
        <form id="createReservationForm" method="POST" action="{{ secure_url(route('reservations.store', [], false)) }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="full_name" class="form-label fw-semibold">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                        <input type="text" id="full_name" name="full_name" class="form-control"
                               value="{{ old('full_name') }}" placeholder="Guest name" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control"
                               value="{{ old('email') }}" placeholder="guest@example.com" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="reservation_date" class="form-label fw-semibold">Date</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" id="reservation_date" name="reservation_date" class="form-control"
                               value="{{ old('reservation_date') }}" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="reservation_time" class="form-label fw-semibold">Time</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-clock"></i></span>
                        <input type="time" id="reservation_time" name="reservation_time" class="form-control"
                               value="{{ old('reservation_time') }}" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="party_size" class="form-label fw-semibold">Party Size</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-people"></i></span>
                        <input type="number" id="party_size" name="party_size" class="form-control"
                               value="{{ old('party_size', 1) }}" min="1" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="pending" @selected(old('status', 'pending') === 'pending')>Pending</option>
                        <option value="confirmed" @selected(old('status') === 'confirmed')>Confirmed</option>
                        <option value="cancelled" @selected(old('status') === 'cancelled')>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="purpose" class="form-label fw-semibold">Purpose</label>
                    <input type="text" id="purpose" name="purpose" class="form-control"
                           value="{{ old('purpose') }}" placeholder="Dinner, meeting, birthday...">
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="btn btn-light border">
                    Cancel
                </a>

                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#confirmCreateModal">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add Reservation
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="confirmCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-calendar-plus text-primary me-1"></i>
                        Add Reservation?
                    </h5>
                    <p class="text-muted small mb-0">Please confirm before saving this reservation.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted mb-0">This will create a new reservation record.</p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="createReservationForm" class="btn btn-primary">
                    <i class="bi bi-check2-circle me-1"></i>
                    Confirm Add
                </button>
            </div>
        </div>
    </div>
</div>

@endsection