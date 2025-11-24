<?php

use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Gestión de usuarios
Route::resource('users', UserController::class);

// Gestión de cine
Route::resource('movies', MovieController::class);
Route::put('movies/{movie}/toggle-status', [MovieController::class, 'toggleStatus'])
    ->name('movies.toggle-status');

Route::resource('rooms', RoomController::class);
Route::resource('showtimes', ShowtimeController::class);

Route::resource('rooms', RoomController::class);
Route::put('rooms/{room}/toggle-status', [RoomController::class, 'toggleStatus'])
    ->name('rooms.toggle-status');
Route::resource('showtimes', ShowtimeController::class);
Route::put('showtimes/{showtime}/toggle-status', [ShowtimeController::class, 'toggleStatus'])
    ->name('showtimes.toggle-status');
