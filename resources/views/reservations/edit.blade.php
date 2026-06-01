@extends('layouts.app')

@section('title', 'Edit Reservation')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Reservation #{{ $reservation->id }}</h1>
        <p class="page-subtitle">Update the booking details below.</p>
    </div>
    <a href="{{ route('reservations.index') }}" class="btn btn-ghost">&larr; Back to List</a>
</div>

@if($errors->any())
    <div class="alert alert-error">
        <strong>Please fix the following errors:</strong>
        <ul class="error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <form method="POST" action="{{ route('reservations.update', $reservation) }}" class="res-form">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">
                <label for="full_name" class="form-label">Full Name <span class="required">*</span></label>
                <input type="text" id="full_name" name="full_name"
                    value="{{ old('full_name', $reservation->full_name) }}"
                    class="input-field @error('full_name') input-error @enderror" required>
                @error('full_name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', $reservation->email) }}"
                    class="input-field @error('email') input-error @enderror" required>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone"
                    value="{{ old('phone', $reservation->phone) }}"
                    class="input-field @error('phone') input-error @enderror">
                @error('phone') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="party_size" class="form-label">Party Size <span class="required">*</span></label>
                <input type="number" id="party_size" name="party_size"
                    value="{{ old('party_size', $reservation->party_size) }}"
                    class="input-field @error('party_size') input-error @enderror"
                    min="1" max="100" required>
                @error('party_size') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="reservation_date" class="form-label">Date <span class="required">*</span></label>
                <input type="date" id="reservation_date" name="reservation_date"
                    value="{{ old('reservation_date', $reservation->reservation_date->format('Y-m-d')) }}"
                    class="input-field @error('reservation_date') input-error @enderror" required>
                @error('reservation_date') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="reservation_time" class="form-label">Time <span class="required">*</span></label>
                <input type="time" id="reservation_time" name="reservation_time"
                    value="{{ old('reservation_time', $reservation->reservation_time) }}"
                    class="input-field @error('reservation_time') input-error @enderror" required>
                @error('reservation_time') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Status (only on Edit) --}}
            <div class="form-group">
                <label for="status" class="form-label">Status <span class="required">*</span></label>
                <select id="status" name="status" class="input-field select-field @error('status') input-error @enderror">
                    <option value="pending"   @selected(old('status', $reservation->status) === 'pending')>Pending</option>
                    <option value="confirmed" @selected(old('status', $reservation->status) === 'confirmed')>Confirmed</option>
                    <option value="cancelled" @selected(old('status', $reservation->status) === 'cancelled')>Cancelled</option>
                </select>
                @error('status') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="purpose" class="form-label">Purpose / Event</label>
                <input type="text" id="purpose" name="purpose"
                    value="{{ old('purpose', $reservation->purpose) }}"
                    class="input-field @error('purpose') input-error @enderror">
                @error('purpose') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group form-full">
                <label for="notes" class="form-label">Additional Notes</label>
                <textarea id="notes" name="notes" rows="3"
                    class="input-field textarea-field @error('notes') input-error @enderror"
                >{{ old('notes', $reservation->notes) }}</textarea>
                @error('notes') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Reservation</button>
            <a href="{{ route('reservations.index') }}" class="btn btn-ghost">Cancel</a>
        </div>

    </form>
</div>

@endsection