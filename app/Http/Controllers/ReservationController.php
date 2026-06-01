<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of all reservations.
     * Supports optional filtering by status via query string: ?status=pending
     */
    public function index(Request $request)
    {
        $query = Reservation::query()->orderBy('reservation_date', 'asc')->orderBy('reservation_time', 'asc');

        // Filter by status if provided
        if ($request->filled('status') && in_array($request->status, ['pending', 'confirmed', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        // Simple search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $reservations = $query->paginate(10)->withQueryString();

        // Pass some stats to the view
        $stats = [
            'total'     => Reservation::count(),
            'pending'   => Reservation::where('status', 'pending')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        return view('reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Show the form to create a new reservation.
     */
    public function create()
    {
        return view('reservations.create');
    }

    /**
     * Store a newly created reservation in the database.
     */
    public function store(Request $request)
    {
        // Validate all incoming form data
        $validated = $request->validate([
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:20',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'party_size'       => 'required|integer|min:1|max:100',
            'purpose'          => 'nullable|string|max:255',
            'notes'            => 'nullable|string|max:1000',
        ]);

        // Status always starts as 'pending' on creation
        $validated['status'] = 'pending';

        Reservation::create($validated);

        return redirect()->route('reservations.index')
                         ->with('success', 'Reservation added successfully!');
    }

    /**
     * Display a single reservation's details.
     */
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form to edit an existing reservation.
     */
    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Update an existing reservation in the database.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:20',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'party_size'       => 'required|integer|min:1|max:100',
            'purpose'          => 'nullable|string|max:255',
            'status'           => 'required|in:pending,confirmed,cancelled',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.index')
                         ->with('success', 'Reservation updated successfully!');
    }

    /**
     * Delete a reservation from the database.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
                         ->with('success', 'Reservation deleted.');
    }

    /**
     * Quick status toggle — called via a small form button on the list.
     * E.g. mark pending → confirmed, or confirmed → cancelled
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $reservation->update(['status' => $request->status]);

        return back()->with('success', 'Status updated!');
    }
}