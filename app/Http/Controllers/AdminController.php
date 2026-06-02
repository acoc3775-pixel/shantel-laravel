<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'reservations' => Reservation::count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        $statusChart = [
            'labels' => ['Pending', 'Confirmed', 'Cancelled'],
            'data' => [
                $stats['pending'],
                $stats['confirmed'],
                $stats['cancelled'],
            ],
        ];

        $monthlyChart = [
            'labels' => [],
            'data' => [],
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $monthlyChart['labels'][] = $date->format('M');

            $monthlyChart['data'][] = Reservation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $recentReservations = Reservation::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'statusChart',
            'monthlyChart',
            'recentReservations',
            'recentUsers'
        ));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'is_admin' => $request->boolean('is_admin'),
        ];

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('admin.users')
            ->with('success', 'User account updated successfully.');
    }
    public function deleteUser(User $user)
{
    if ($user->id === auth()->id()) {
        return redirect()
            ->route('admin.users')
            ->with('error', 'You cannot delete your own account.');
    }

    if ($user->avatar && file_exists(public_path('uploads/avatars/' . $user->avatar))) {
        unlink(public_path('uploads/avatars/' . $user->avatar));
    }

    $user->delete();

    return redirect()
        ->route('admin.users')
        ->with('success', 'User account deleted successfully.');
}
}