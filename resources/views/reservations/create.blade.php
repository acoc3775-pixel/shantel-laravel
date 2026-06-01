@extends('layouts.app')

@section('title', 'New Reservation')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">New Reservation</h1>
        <p class="page-subtitle">Fill in the details below to add a booking.</p>
    </div>
    <a href="{{ route('reservations.index') }}" class="btn btn-ghost">&larr; Back to List</a>
</div>

{{-- Validation Errors --}}
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
    <form method="POST" action="{{ route('reservations.store') }}" class="res-form">
        @csrf

        <div class="form-grid">

            {{-- Full Name --}}
            <div class="form-group">
                <label for="full_name" class="form-label">Full Name <span class="required">*</span></label>
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    value="{{ old('full_name') }}"
                    class="input-field @error('full_name') input-error @enderror"
                    placeholder="Juan dela Cruz"
                    required
                >
                @error('full_name')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="input-field @error('email') input-error @enderror"
                    placeholder="juan@email.com"
                    required
                >
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="input-field @error('phone') input-error @enderror"
                    placeholder="09XX-XXX-XXXX"
                >
                @error('phone')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Party Size --}}
            <div class="form-group">
                <label for="party_size" class="form-label">Party Size <span class="required">*</span></label>
                <input
                    type="number"
                    id="party_size"
                    name="party_size"
                    value="{{ old('party_size', 1) }}"
                    class="input-field @error('party_size') input-error @enderror"
                    min="1" max="100"
                    required
                >
                @error('party_size')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Reservation Date --}}
            <div class="form-group">
                <label for="reservation_date" class="form-label">Date <span class="required">*</span></label>
                <input
                    type="date"
                    id="reservation_date"
                    name="reservation_date"
                    value="{{ old('reservation_date') }}"
                    class="input-field @error('reservation_date') input-error @enderror"
                    min="{{ date('Y-m-d') }}"
                    required
                >
                @error('reservation_date')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Reservation Time --}}
            <div class="form-group">
                <label for="reservation_time" class="form-label">Time <span class="required">*</span></label>
                <input
                    type="time"
                    id="reservation_time"
                    name="reservation_time"
                    value="{{ old('reservation_time') }}"
                    class="input-field @error('reservation_time') input-error @enderror"
                    required
                >
                @error('reservation_time')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Purpose --}}
            <div class="form-group form-full">
                <label for="purpose" class="form-label">Purpose / Event</label>
                <input
                    type="text"
                    id="purpose"
                    name="purpose"
                    value="{{ old('purpose') }}"
                    class="input-field @error('purpose') input-error @enderror"
                    placeholder="Birthday, Business Meeting, Anniversary..."
                >
                @error('purpose')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Notes --}}
            <div class="form-group form-full">
                <label for="notes" class="form-label">Additional Notes</label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    class="input-field textarea-field @error('notes') input-error @enderror"
                    placeholder="Any special requests or instructions..."
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Reservation</button>
            <a href="{{ route('reservations.index') }}" class="btn btn-ghost">Cancel</a>
        </div>

    </form>
</div>

@endsection