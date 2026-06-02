<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;

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
}