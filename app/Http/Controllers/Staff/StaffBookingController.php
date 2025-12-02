<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Showtime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffBookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'showtime.movie', 'showtime.room'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('staff.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $users = User::where('is_active', true)->get();
        $showtimes = Showtime::with(['movie', 'room'])
            ->where('start_time', '>', now())
            ->where('is_active', true)
            ->where('available_seats', '>', 0)
            ->orderBy('start_time')
            ->get();

        return view('staff.bookings.create', compact('users', 'showtimes'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'number_of_tickets' => 'required|integer|min:1|max:10',
        ]);

        try {
            DB::beginTransaction();

            $showtime = Showtime::findOrFail($request->showtime_id);
            $user = User::findOrFail($request->user_id);

            // Verificar disponibilidad
            if ($showtime->available_seats < $request->number_of_tickets) {
                return back()->with('error', 'No hay suficientes asientos disponibles.');
            }

            $totalPrice = $showtime->price * $request->number_of_tickets;

            // Crear la reserva
            $booking = Booking::create([
                'user_id' => $request->user_id,
                'showtime_id' => $request->showtime_id,
                'number_of_tickets' => $request->number_of_tickets,
                'total_price' => $totalPrice,
                'status' => 'confirmed',
            ]);

            // Actualizar asientos disponibles
            $showtime->decrement('available_seats', $request->number_of_tickets);

            DB::commit();

            return redirect()->route('staff.bookings.index')
                ->with('success', 'Reserva creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear la reserva: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'showtime.movie', 'showtime.room']);
        return view('staff.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        $users = User::where('is_active', true)->get();
        $showtimes = Showtime::with(['movie', 'room'])
            ->where('start_time', '>', now())
            ->where('is_active', true)
            ->orderBy('start_time')
            ->get();

        return view('staff.bookings.edit', compact('booking', 'users', 'showtimes'));
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'number_of_tickets' => 'required|integer|min:1|max:10',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($request->all());

        return redirect()->route('staff.bookings.index')
            ->with('success', 'Reserva actualizada exitosamente.');
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('staff.bookings.index')
            ->with('success', 'Reserva eliminada exitosamente.');
    }

    /**
     * Toggle booking status.
     */
    public function toggleStatus(Booking $booking)
    {
        $booking->update([
            'status' => $booking->status === 'confirmed' ? 'cancelled' : 'confirmed'
        ]);

        return back()->with('success', 'Estado de la reserva actualizado.');
    }

    /**
     * Display today's bookings.
     */
    public function today()
    {
        $today = now()->format('Y-m-d');

        $bookings = Booking::with(['user', 'showtime.movie', 'showtime.room'])
            ->whereHas('showtime', function($query) use ($today) {
                $query->whereDate('start_time', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.bookings.today', compact('bookings'));
    }
}
