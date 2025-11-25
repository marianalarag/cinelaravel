<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Hall;
use Illuminate\Http\Request;

class StaffShowtimeController extends Controller
{
    public function index()
    {
        $showtimes = Showtime::with(['movie', 'room'])
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('staff.showtimes.index', compact('showtimes'));
    }

    public function create()
    {
        $movies = Movie::where('is_active', true)->get();
        $halls = Hall::where('is_active', true)->get();

        return view('staff.showtimes.create', compact('movies', 'halls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'hall_id' => 'required|exists:halls,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'price' => 'required|numeric|min:0',
        ]);

        Showtime::create($request->all());

        return redirect()->route('staff.showtimes.index')
            ->with('success', 'Función creada exitosamente.');
    }

    public function show(Showtime $showtime)
    {
        $showtime->load(['movie', 'room', 'bookings.user']);

        return view('staff.showtimes.show', compact('showtime'));
    }

    public function today()
    {
        $showtimes = Showtime::with(['movie', 'room'])
            ->whereDate('start_time', today())
            ->orderBy('start_time')
            ->get();

        return view('staff.showtimes.today', compact('showtimes'));
    }

    public function toggleStatus(Showtime $showtime)
    {
        $showtime->update([
            'is_active' => !$showtime->is_active
        ]);

        return back()->with('success', 'Estado de la función actualizado.');
    }
}
