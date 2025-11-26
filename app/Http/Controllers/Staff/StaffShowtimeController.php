<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Hall;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StaffShowtimeController extends Controller
{
    /**
     * Display a listing of the showtimes.
     */
    public function index()
    {
        $showtimes = Showtime::with(['movie', 'room'])
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        return view('staff.showtimes.index', compact('showtimes'));
    }

    /**
     * Show the form for creating a new showtime.
     */
    public function create()
    {
        $movies = Movie::where('is_active', true)->get();
        $halls = Hall::where('is_active', true)->get();

        return view('staff.showtimes.create', compact('movies', 'halls'));
    }

    /**
     * Store a newly created showtime.
     */
    public function store(Request $request)
    {
        // Validaciones para SHOWTIMES
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'room_id' => 'required|exists:halls,id',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
        ]);

        try {
            // Combinar fecha y hora
            $startDateTime = $request->start_date . ' ' . $request->start_time;

            // Verificar que la fecha/hora sea en el futuro
            if (Carbon::parse($startDateTime)->lte(now())) {
                return back()->withErrors(['start_time' => 'La función debe programarse en el futuro.']);
            }

            // Obtener la película para calcular la duración
            $movie = Movie::findOrFail($request->movie_id);
            $endDateTime = Carbon::parse($startDateTime)->addMinutes($movie->duration + 30);

            // Verificar conflictos de horario
            $conflictingShowtime = Showtime::where('room_id', $request->room_id)
                ->where('is_active', true)
                ->where(function($query) use ($startDateTime, $endDateTime) {
                    $query->whereBetween('start_time', [$startDateTime, $endDateTime])
                        ->orWhereBetween('end_time', [$startDateTime, $endDateTime])
                        ->orWhere(function($q) use ($startDateTime, $endDateTime) {
                            $q->where('start_time', '<=', $startDateTime)
                                ->where('end_time', '>=', $endDateTime);
                        });
                })
                ->exists();

            if ($conflictingShowtime) {
                return back()->withErrors(['start_time' => 'Ya hay una función programada en esta sala en ese horario.']);
            }

            // Crear el showtime
            Showtime::create([
                'movie_id' => $request->movie_id,
                'room_id' => $request->room_id,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'price' => $request->price,
                'available_seats' => $request->available_seats,
                'is_active' => true,
            ]);

            return redirect()->route('staff.showtimes.index')
                ->with('success', 'Función creada exitosamente.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la función: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified showtime.
     */
    public function show(Showtime $showtime)
    {
        $showtime->load(['movie', 'room']);
        return view('staff.showtimes.show', compact('showtime'));
    }

    /**
     * Show the form for editing the specified showtime.
     */
    public function edit(Showtime $showtime)
    {
        $movies = Movie::where('is_active', true)->get();
        $halls = Hall::where('is_active', true)->get();

        return view('staff.showtimes.edit', compact('showtime', 'movies', 'halls'));
    }

    /**
     * Update the specified showtime.
     */
    public function update(Request $request, Showtime $showtime)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'room_id' => 'required|exists:halls,id',
            'start_time' => 'required|date',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
        ]);

        $showtime->update($request->all());

        return redirect()->route('staff.showtimes.index')
            ->with('success', 'Función actualizada exitosamente.');
    }

    /**
     * Remove the specified showtime.
     */
    public function destroy(Showtime $showtime)
    {
        $showtime->delete();

        return redirect()->route('staff.showtimes.index')
            ->with('success', 'Función eliminada exitosamente.');
    }

    /**
     * Toggle showtime status.
     */
    public function toggleStatus(Showtime $showtime)
    {
        $showtime->update([
            'is_active' => !$showtime->is_active
        ]);

        return back()->with('success', 'Estado de la función actualizado.');
    }

    /**
     * Display today's showtimes.
     */
    public function today()
    {
        $today = now()->format('Y-m-d');

        $showtimes = Showtime::with(['movie', 'room'])
            ->whereDate('start_time', $today)
            ->where('is_active', true)
            ->orderBy('start_time')
            ->get();

        return view('staff.showtimes.today', compact('showtimes'));
    }
}
