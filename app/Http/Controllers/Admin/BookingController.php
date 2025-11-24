<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'showtime.movie', 'showtime.room'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('admin.bookings.create');
    }

    public function store(Request $request)
    {
        // Lógica para crear reservas
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Reserva creada correctamente.');
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        // Lógica para actualizar reservas
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Reserva actualizada correctamente.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Reserva eliminada correctamente.');
    }

    public function toggleStatus(Booking $booking)
    {
        $booking->update(['is_active' => !$booking->is_active]);
        $status = $booking->is_active ? 'activada' : 'desactivada';
        return redirect()->route('admin.bookings.index')
            ->with('success', "Reserva {$status} correctamente.");
    }
}
