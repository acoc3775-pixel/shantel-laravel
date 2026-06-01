<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Laravel will auto-guess 'reservations' but being explicit is good practice)
     */
    protected $table = 'reservations';

    /**
     * Mass assignable fields.
     * These are the columns we allow to be filled via create() or fill().
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'reservation_date',
        'reservation_time',
        'party_size',
        'purpose',
        'status',
        'notes',
    ];

    /**
     * Cast certain columns to native PHP types automatically.
     */
    protected $casts = [
        'reservation_date' => 'date',
        'party_size'        => 'integer',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    /**
     * Only return upcoming reservations (today and future).
     */
    public function scopeUpcoming($query)
    {
        return $query->where('reservation_date', '>=', now()->toDateString());
    }

    /**
     * Filter by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // ─── Accessors ───────────────────────────────────────────────────────────

    /**
     * Return a human-readable badge class for the current status.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'badge-confirmed',
            'cancelled' => 'badge-cancelled',
            default     => 'badge-pending',
        };
    }

    /**
     * Return formatted date + time together.
     */
    public function getFormattedDateTimeAttribute(): string
    {
        return $this->reservation_date->format('M d, Y') . ' at ' . $this->reservation_time;
    }
}