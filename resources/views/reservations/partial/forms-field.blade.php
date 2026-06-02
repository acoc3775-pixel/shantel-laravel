@php
    $editing = isset($reservation) && $reservation;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="full_name_{{ $editing ? $reservation->id : 'new' }}" class="form-label fw-semibold">Full Name</label>
        <div class="input-group">
            <span class="input-group-text bg-light">
                <i class="bi bi-person"></i>
            </span>
            <input type="text"
                   id="full_name_{{ $editing ? $reservation->id : 'new' }}"
                   name="full_name"
                   class="form-control"
                   value="{{ old('full_name', $editing ? $reservation->full_name : auth()->user()->name) }}"
                   placeholder="Guest name"
                   required>
        </div>
    </div>

    <div class="col-md-6">
        <label for="email_{{ $editing ? $reservation->id : 'new' }}" class="form-label fw-semibold">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-light">
                <i class="bi bi-envelope"></i>
            </span>
            <input type="email"
                   id="email_{{ $editing ? $reservation->id : 'new' }}"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $editing ? $reservation->email : auth()->user()->email) }}"
                   placeholder="guest@example.com"
                   required>
        </div>
    </div>

    <div class="col-md-4">
        <label for="reservation_date_{{ $editing ? $reservation->id : 'new' }}" class="form-label fw-semibold">Date</label>
        <div class="input-group">
            <span class="input-group-text bg-light">
                <i class="bi bi-calendar-event"></i>
            </span>
            <input type="date"
                   id="reservation_date_{{ $editing ? $reservation->id : 'new' }}"
                   name="reservation_date"
                   class="form-control"
                   value="{{ old('reservation_date', $editing ? $reservation->reservation_date->format('Y-m-d') : '') }}"
                   required>
        </div>
    </div>

    <div class="col-md-4">
        <label for="reservation_time_{{ $editing ? $reservation->id : 'new' }}" class="form-label fw-semibold">Time</label>
        <div class="input-group">
            <span class="input-group-text bg-light">
                <i class="bi bi-clock"></i>
            </span>
            <input type="time"
                   id="reservation_time_{{ $editing ? $reservation->id : 'new' }}"
                   name="reservation_time"
                   class="form-control"
                   value="{{ old('reservation_time', $editing ? \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') : '') }}"
                   required>
        </div>
    </div>

    <div class="col-md-4">
        <label for="party_size_{{ $editing ? $reservation->id : 'new' }}" class="form-label fw-semibold">Party Size</label>
        <div class="input-group">
            <span class="input-group-text bg-light">
                <i class="bi bi-people"></i>
            </span>
            <input type="number"
                   id="party_size_{{ $editing ? $reservation->id : 'new' }}"
                   name="party_size"
                   class="form-control"
                   value="{{ old('party_size', $editing ? $reservation->party_size : 1) }}"
                   min="1"
                   required>
        </div>
    </div>

    <div class="col-12">
        <label for="purpose_{{ $editing ? $reservation->id : 'new' }}" class="form-label fw-semibold">Purpose</label>
        <input type="text"
               id="purpose_{{ $editing ? $reservation->id : 'new' }}"
               name="purpose"
               class="form-control"
               value="{{ old('purpose', $editing ? $reservation->purpose : '') }}"
               placeholder="Dinner, meeting, birthday, appointment...">
    </div>

    <div class="col-12">
        <div class="alert alert-light border mb-0">
            <i class="bi bi-info-circle text-primary me-1"></i>
            Booking status will be set to <strong>Pending</strong> and can only be updated by an admin.
        </div>
    </div>
</div>