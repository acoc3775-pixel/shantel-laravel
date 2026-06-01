@extends('layouts.app')

@section('title', 'Reservation #' . $reservation->id)

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Reservation #{{ $reservation->id }}</h1>
        <p class="page-subtitle">Created {{ $reservation->created_at->diffForHumans() }}</p>
    </div>
    <div style="display:flex;gap:.5rem;">
        <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('reservations.index') }}" class="btn btn-ghost">&larr; Back</a>
    </div>
</div>

<div class="card detail-card">

    <div class="detail-badge-row">
        <span class="badge {{ $reservation->status_badge }} badge-lg">
            {{ ucfirst($reservation->status) }}
        </span>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <span class="detail-label">👤 Full Name</span>
            <span class="detail-value">{{ $reservation->full_name }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">📧 Email</span>
            <span class="detail-value">{{ $reservation->email }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">📱 Phone</span>
            <span class="detail-value">{{ $reservation->phone ?? 'Not provided' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">👥 Party Size</span>
            <span class="detail-value">{{ $reservation->party_size }} person/s</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">📅 Date</span>
            <span class="detail-value">{{ $reservation->reservation_date->format('F d, Y') }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">🕐 Time</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">🎉 Purpose</span>
            <span class="detail-value">{{ $reservation->purpose ?? 'Not specified' }}</span>
        </div>
        <div class="detail-item detail-item-full">
            <span class="detail-label">📝 Notes</span>
            <span class="detail-value">{{ $reservation->notes ?? 'None' }}</span>
        </div>
    </div>

    {{-- Quick Status Change --}}
    <div class="detail-actions">
        <h3 class="section-subtitle">Change Status</h3>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
            @foreach(['pending','confirmed','cancelled'] as $status)
                @if($status !== $reservation->status)
                    <form method="POST" action="{{ route('reservations.updateStatus', $reservation) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="btn btn-secondary btn-sm">
                            Mark as {{ ucfirst($status) }}
                        </button>
                    </form>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Delete --}}
    <div class="detail-delete">
        <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
              onsubmit="return confirm('Are you sure you want to delete this reservation? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">🗑 Delete Reservation</button>
        </form>
    </div>

</div>

@endsection