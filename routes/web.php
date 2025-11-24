<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\HallController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard principal - redirecciona al admin dashboard si es admin
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard mejorado - redirecciona al admin dashboard si es admin
    Route::get('/dashboard', function () {
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Admin Routes Group
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
