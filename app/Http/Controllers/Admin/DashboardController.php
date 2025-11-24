<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Booking;
use App\Models\Showtime;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_movies' => Movie::count(),
            'active_movies' => Movie::where('is_active', true)->count(),
            'today_showtimes' => Showtime::whereDate('start_time', today())->count(),
            'today_bookings' => Booking::whereDate('created_at', today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
