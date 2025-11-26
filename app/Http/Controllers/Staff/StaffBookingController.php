<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Room; // o Hall, dependiendo de tu modelo
use Illuminate\Http\Request;

class StaffShowtimeController extends Controller
{
    public function create()
    {
        $movies = Movie::where('is_active', true)->get();

        // Verifica qué modelo existe en tu sistema
        if (class_exists('App\Models\Room')) {
            $rooms = \App\Models\Room::where('is_active', true)->get();
        } elseif (class_exists('App\Models\Hall')) {
            $rooms = \App\Models\Hall::where('is_active', true)->get();
        } else {
            $rooms = collect(); // Colección vacía si no hay ningún modelo
        }

        return view('staff.showtimes.create', compact('movies', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'room_id' => 'required|exists:rooms,id', // o halls,id
            'start_date' => 'required|date',
            'start_time' => 'required',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
        ]);

        // Combinar fecha y hora
        $startDateTime = $request->start_date . ' ' . $request->start_time;

        // Calcular hora de fin (duración de la película + 30 minutos de limpieza)
        $movie = Movie::find($request->movie_id);
        $endDateTime = \Carbon\Carbon::parse($startDateTime)
            ->addMinutes($movie->duration + 30);

        // Verificar conflictos de horario
        $conflictingShowtime = \App\Models\Showtime::where('room_id', $request->room_id)
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
            return back()->withErrors(['start_time' => 'Ya hay una función programada en esta sala a esa hora.']);
        }

        \App\Models\Showtime::create([
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
    }
}
