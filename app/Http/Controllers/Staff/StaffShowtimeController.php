<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Hall;
use Illuminate\Http\Request;
use App\Models\Booking;

class StaffShowtimeController extends Controller
{
    public function index()
    {
        try {
            $showtimes = Showtime::with(['movie', 'hall', 'room', 'sala'])
                ->orderBy('start_time', 'desc')
                ->paginate(10);
        } catch (\Exception $e) {
            $showtimes = Showtime::with(['movie'])
                ->orderBy('start_time', 'desc')
                ->paginate(10);
        }

        return view('staff.showtimes.index', compact('showtimes'));
    }

    public function create()
    {
        $movies = Movie::where('is_active', true)->get();

        // Intentar cargar halls/rooms de diferentes maneras
        try {
            $halls = Hall::where('is_active', true)->get();
        } catch (\Exception $e) {
            // Si Hall no existe, intentar con Room
            try {
                $halls = \App\Models\Room::where('is_active', true)->get();
            } catch (\Exception $e) {
                $halls = collect(); // Colección vacía
            }
        }

        return view('staff.showtimes.create', compact('movies', 'halls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'number_of_tickets' => 'required|integer|min:1|max:10',
        ]);

        // Lógica para crear reserva (similar a ClientBookingController)
        $showtime = Showtime::findOrFail($request->showtime_id);

        if ($showtime->available_seats < $request->number_of_tickets) {
            return back()->with('error', 'No hay suficientes asientos disponibles.');
        }

        $totalPrice = $showtime->price * $request->number_of_tickets;

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'showtime_id' => $request->showtime_id,
            'number_of_tickets' => $request->number_of_tickets,
            'total_amount' => $totalPrice,
            'status' => 'confirmed',
        ]);

        $showtime->decrement('available_seats', $request->number_of_tickets);

        return redirect()->route('staff.bookings.index')
            ->with('success', 'Reserva creada exitosamente.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'showtime.movie', 'showtime.hall']);
        return view('staff.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $booking->load(['user', 'showtime.movie', 'showtime.hall']);
        $showtimes = Showtime::with(['movie', 'hall'])->where('start_time', '>', now())->get();
        $users = User::role('client')->get();

        return view('staff.bookings.edit', compact('booking', 'showtimes', 'users'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'number_of_tickets' => 'required|integer|min:1|max:10',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        // Lógica de actualización
        $originalTickets = $booking->number_of_tickets;
        $newTickets = $request->number_of_tickets;

        if ($booking->showtime_id != $request->showtime_id) {
            // Devolver asientos al showtime original
            $booking->showtime->increment('available_seats', $originalTickets);

            // Nuevo showtime
            $newShowtime = Showtime::findOrFail($request->showtime_id);
            if ($newShowtime->available_seats < $newTickets) {
                return back()->with('error', 'No hay suficientes asientos disponibles en el nuevo horario.');
            }
            $newShowtime->decrement('available_seats', $newTickets);

            $totalPrice = $newShowtime->price * $newTickets;
        } else {
            // Mismo showtime, ajustar asientos
            $ticketDifference = $newTickets - $originalTickets;
            if ($ticketDifference > 0 && $booking->showtime->available_seats < $ticketDifference) {
                return back()->with('error', 'No hay suficientes asientos disponibles.');
            }

            $booking->showtime->decrement('available_seats', $ticketDifference);
            $totalPrice = $booking->showtime->price * $newTickets;
        }

        $booking->update([
            'user_id' => $request->user_id,
            'showtime_id' => $request->showtime_id,
            'number_of_tickets' => $newTickets,
            'total_amount' => $totalPrice,
            'status' => $request->status,
        ]);

        return redirect()->route('staff.bookings.index')
            ->with('success', 'Reserva actualizada exitosamente.');
    }

    public function destroy(Booking $booking)
    {
        // Devolver asientos al showtime
        $booking->showtime->increment('available_seats', $booking->number_of_tickets);

        $booking->delete();

        return redirect()->route('staff.bookings.index')
            ->with('success', 'Reserva eliminada exitosamente.');
    }

    public function today()
    {
        $todayShowtimes = Showtime::with(['movie', 'room'])
            ->whereDate('start_time', today())
            ->orderBy('start_time')
            ->paginate(10);

        return view('staff.showtimes.today', compact('todayShowtimes')); // <-- Cambiar a 'staff.showtimes.today'
    }

    public function toggleStatus(Booking $booking)
    {
        $newStatus = $booking->status === 'confirmed' ? 'cancelled' : 'confirmed';
        $booking->update(['status' => $newStatus]);

        $message = $newStatus === 'confirmed'
            ? 'Reserva confirmada exitosamente.'
            : 'Reserva cancelada exitosamente.';

        return back()->with('success', $message);
    }
}
