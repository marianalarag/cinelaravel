<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Showtime;
use App\Models\User;
use Illuminate\Http\Request;

class StaffBookingController extends Controller
{
    public function index()
    {
        try {
            // Intentar cargar con diferentes nombres de relación
            $bookings = Booking::with([
                'user',
                'showtime.movie',
                'showtime.hall',    // Intentar con hall
                'showtime.room',    // Intentar con room
                'showtime.sala'     // Intentar con sala
            ])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

        } catch (\Exception $e) {
            // Si falla, cargar solo relaciones básicas
            $bookings = Booking::with(['user', 'showtime.movie'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('staff.bookings.index', compact('bookings'));
    }

    public function create()
    {
        try {
            $showtimes = Showtime::with(['movie', 'hall', 'room', 'sala'])
                ->where('start_time', '>', now())
                ->get();
        } catch (\Exception $e) {
            $showtimes = Showtime::with(['movie'])
                ->where('start_time', '>', now())
                ->get();
        }

        $users = User::role('client')->get();

        return view('staff.bookings.create', compact('showtimes', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'number_of_tickets' => 'required|integer|min:1|max:10',
        ]);

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
        try {
            $booking->load([
                'user',
                'showtime.movie',
                'showtime.hall',
                'showtime.room',
                'showtime.sala'
            ]);
        } catch (\Exception $e) {
            $booking->load(['user', 'showtime.movie']);
        }

        return view('staff.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        try {
            $booking->load([
                'user',
                'showtime.movie',
                'showtime.hall',
                'showtime.room',
                'showtime.sala'
            ]);
        } catch (\Exception $e) {
            $booking->load(['user', 'showtime.movie']);
        }

        try {
            $showtimes = Showtime::with(['movie', 'hall', 'room', 'sala'])
                ->where('start_time', '>', now())
                ->get();
        } catch (\Exception $e) {
            $showtimes = Showtime::with(['movie'])
                ->where('start_time', '>', now())
                ->get();
        }

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
        try {
            $todayBookings = Booking::with([
                'user',
                'showtime.movie',
                'showtime.hall',
                'showtime.room',
                'showtime.sala'
            ])
                ->whereHas('showtime', function($query) {
                    $query->whereDate('start_time', today());
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } catch (\Exception $e) {
            $todayBookings = Booking::with(['user', 'showtime.movie'])
                ->whereHas('showtime', function($query) {
                    $query->whereDate('start_time', today());
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('staff.bookings.today', compact('todayBookings'));
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
