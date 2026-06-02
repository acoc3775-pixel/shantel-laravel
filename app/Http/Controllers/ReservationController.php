<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = auth()->user()->is_admin ?? false;

        $baseQuery = Reservation::query();

        if (! $isAdmin) {
            $baseQuery->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $baseQuery->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('purpose', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        $statsQuery = Reservation::query();

        if (! $isAdmin) {
            $statsQuery->where('user_id', auth()->id());
        }

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'pending' => (clone $statsQuery)->where('status', 'pending')->count(),
            'confirmed' => (clone $statsQuery)->where('status', 'confirmed')->count(),
            'cancelled' => (clone $statsQuery)->where('status', 'cancelled')->count(),
        ];

        $reservations = $baseQuery->latest()->paginate(10)->withQueryString();

        return view('reservations.index', compact('reservations', 'stats', 'isAdmin'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'reservation_date' => ['required', 'date'],
            'reservation_time' => ['required'],
            'party_size' => ['required', 'integer', 'min:1'],
            'purpose' => ['nullable', 'string', 'max:255'],
        ]);

        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        Reservation::create($data);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation submitted successfully. Status is now pending.');
    }

    public function update(Request $request, Reservation $reservation)
    {
        $isAdmin = auth()->user()->is_admin ?? false;

        if (! $isAdmin && $reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'reservation_date' => ['required', 'date'],
            'reservation_time' => ['required'],
            'party_size' => ['required', 'integer', 'min:1'],
            'purpose' => ['nullable', 'string', 'max:255'],
        ]);

        $reservation->update($data);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        if (! (auth()->user()->is_admin ?? false)) {
            abort(403);
        }

        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
        ]);

        $reservation->update([
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation status updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $isAdmin = auth()->user()->is_admin ?? false;

        if (! $isAdmin && $reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->delete();

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }
}