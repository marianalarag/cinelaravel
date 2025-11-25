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
        $bookings = Booking::with(['user', 'showtime.movie'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('staff.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $showtimes = Showtime::with('movie')->where('start_time', '>', now())->get();
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
        $totalPrice = $showtime->price * $request->number_of_tickets;

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'showtime_id' => $request->showtime_id,
            'number_of_tickets' => $request->number_of_tickets,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);

        return redirect()->route('staff.bookings.index')
            ->with('success', 'Reserva creada exitosamente.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'showtime.movie', 'showtime.room']);

        return view('staff.bookings.show', compact('booking'));
    }

    public function today()
    {
        $bookings = Booking::with(['user', 'showtime.movie'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('staff.bookings.today', compact('bookings'));
    }

    public function toggleStatus(Booking $booking)
    {
        $booking->update([
            'status' => $booking->status === 'confirmed' ? 'cancelled' : 'confirmed'
        ]);

        return back()->with('success', 'Estado de la reserva actualizado.');
    }
}
