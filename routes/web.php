<?php

use App\Http\Controllers\Client\ClientMovieController;
use App\Http\Controllers\Client\ClientBookingController;
use App\Http\Controllers\Staff\StaffBookingController;
use App\Http\Controllers\Staff\StaffShowtimeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\Admin\HallController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ==================== RUTA PRINCIPAL ====================
Route::get('/', function () {
    // Redirigir directamente a la página de películas
    return redirect()->route('movies.index');
})->name('home');


// ==================== RUTAS PÚBLICAS ====================
// Ruta dashboard pública que redirige según autenticación y rol
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('staff')) {
            return redirect()->route('staff.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }
    return redirect('/');
})->name('dashboard');

// Rutas públicas para películas (accesibles sin login)
Route::get('/movies', [ClientMovieController::class, 'index'])->name('movies.index');
Route::get('/movies/now-showing', [ClientMovieController::class, 'nowShowing'])->name('movies.now-showing');
Route::get('/movies/coming-soon', [ClientMovieController::class, 'comingSoon'])->name('movies.coming-soon');
Route::get('/movies/{movie}', [ClientMovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{movie}/showtimes', [ClientMovieController::class, 'showtimes'])->name('movies.showtimes');

// ==================== RUTAS AUTENTICADAS ====================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // ==================== CLIENT ROUTES ====================
    Route::prefix('client')->name('client.')->middleware(['role:client'])->group(function () {
        // Dashboard Cliente
        Route::get('/dashboard', function () {
            return view('dashboard.client');
        })->name('dashboard');

        // Mis Reservas
        Route::get('/my-bookings', [ClientBookingController::class, 'myBookings'])->name('bookings.my-bookings');
        Route::get('/bookings/{booking}', [ClientBookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings', [ClientBookingController::class, 'store'])->name('bookings.store');
        Route::delete('/bookings/{booking}', [ClientBookingController::class, 'cancel'])->name('bookings.cancel');

        // Películas para cliente
        Route::get('/movies', [ClientMovieController::class, 'index'])->name('movies.index');
        Route::get('/movies/{movie}', [ClientMovieController::class, 'show'])->name('movies.show');
        Route::get('/movies/{movie}/showtimes', [ClientMovieController::class, 'showtimes'])->name('movies.showtimes');
        Route::get('/movies/now-showing', [ClientMovieController::class, 'nowShowing'])->name('movies.now-showing');
        Route::get('/movies/coming-soon', [ClientMovieController::class, 'comingSoon'])->name('movies.coming-soon');
    });

// ==================== STAFF ROUTES ====================
    Route::prefix('staff')->name('staff.')->middleware(['role:staff'])->group(function () {
        // Dashboard Staff
        Route::get('/dashboard', function () {
            return view('dashboard.staff');
        })->name('dashboard');

        // Gestión de Reservas
        Route::get('/bookings', [StaffBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create', [StaffBookingController::class, 'create'])->name('bookings.create');
        Route::get('/bookings/today', [StaffBookingController::class, 'today'])->name('bookings.today'); // <-- AGREGAR
        Route::post('/bookings', [StaffBookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [StaffBookingController::class, 'show'])->name('bookings.show');
        Route::get('/bookings/{booking}/edit', [StaffBookingController::class, 'edit'])->name('bookings.edit');
        Route::put('/bookings/{booking}', [StaffBookingController::class, 'update'])->name('bookings.update');
        Route::delete('/bookings/{booking}', [StaffBookingController::class, 'destroy'])->name('bookings.destroy');
        Route::put('/bookings/{booking}/toggle-status', [StaffBookingController::class, 'toggleStatus'])
            ->name('bookings.toggle-status');

        // Gestión de Funciones
        Route::get('/showtimes', [StaffShowtimeController::class, 'index'])->name('showtimes.index');
        Route::get('/showtimes/create', [StaffShowtimeController::class, 'create'])->name('showtimes.create');
        Route::get('/showtimes/today', [StaffShowtimeController::class, 'today'])->name('showtimes.today');
        Route::post('/showtimes', [StaffShowtimeController::class, 'store'])->name('showtimes.store');
        Route::get('/showtimes/{showtime}', [StaffShowtimeController::class, 'show'])->name('showtimes.show');
        Route::get('/showtimes/{showtime}/edit', [StaffShowtimeController::class, 'edit'])->name('showtimes.edit');
        Route::put('/showtimes/{showtime}', [StaffShowtimeController::class, 'update'])->name('showtimes.update');
        Route::delete('/showtimes/{showtime}', [StaffShowtimeController::class, 'destroy'])->name('showtimes.destroy');
        Route::put('/showtimes/{showtime}/toggle-status', [StaffShowtimeController::class, 'toggleStatus'])
            ->name('showtimes.toggle-status');
    });

    // ==================== ADMIN ROUTES ====================
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Movies Resource Routes
        Route::resource('movies', MovieController::class);
        Route::put('/movies/{movie}/toggle-status', [MovieController::class, 'toggleStatus'])
            ->name('movies.toggle-status');

        // Showtimes Resource Routes
        Route::resource('showtimes', ShowtimeController::class);
        Route::put('/showtimes/{showtime}/toggle-status', [ShowtimeController::class, 'toggleStatus'])
            ->name('showtimes.toggle-status');

        // Halls/Rooms Resource Routes
        Route::resource('halls', HallController::class)->names([
            'index' => 'halls.index',
            'create' => 'halls.create',
            'store' => 'halls.store',
            'show' => 'halls.show',
            'edit' => 'halls.edit',
            'update' => 'halls.update',
            'destroy' => 'halls.destroy',
        ]);
        Route::put('/halls/{hall}/toggle-status', [HallController::class, 'toggleStatus'])
            ->name('halls.toggle-status');

        // Genres Resource Routes
        Route::resource('genres', GenreController::class);
        Route::put('/genres/{genre}/toggle-status', [GenreController::class, 'toggleStatus'])
            ->name('genres.toggle-status');

        // Users Resource Routes
        Route::resource('users', UserController::class);
        Route::put('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');

        // Bookings Resource Routes
        Route::resource('bookings', BookingController::class);
        Route::put('/bookings/{booking}/toggle-status', [BookingController::class, 'toggleStatus'])
            ->name('bookings.toggle-status');
    });
});
