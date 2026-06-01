<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| All routes for the Reservation List application.
| We use Route::resource() to automatically generate the 7 RESTful routes
| (index, create, store, show, edit, update, destroy).
*/

// Redirect root to reservations list
Route::get('/', fn () => redirect()->route('reservations.index'));

// Resourceful CRUD routes for reservations
Route::resource('reservations', ReservationController::class);

// Extra route for quick status update (PATCH /reservations/{id}/status)
Route::patch('reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])
     ->name('reservations.updateStatus');