<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientBookingController extends Controller
{
    public function myBookings()
    {
        // Primero obtener las reservas sin relaciones
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Luego cargar relaciones de forma segura
        $bookings->load(['showtime.movie']);

        // Intentar cargar la relación de la sala si existe
        foreach ($bookings as $booking) {
            if ($booking->showtime && method_exists($booking->showtime, 'hall')) {
                $booking->showtime->load('hall');
            } elseif ($booking->showtime && method_exists($booking->showtime, 'room')) {
                $booking->showtime->load('room');
            } elseif ($booking->showtime && method_exists($booking->showtime, 'sala')) {
                $booking->showtime->load('sala');
            }
        }

        return view('client.bookings.my-bookings', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Verificar que la reserva pertenece al usuario autenticado
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'No tienes permisos para ver esta reserva.');
        }

        // Cargar relaciones básicas
        $booking->load(['showtime.movie', 'user']);

        // Intentar cargar relación de sala
        if ($booking->showtime) {
            if (method_exists($booking->showtime, 'hall')) {
                $booking->showtime->load('hall');
            } elseif (method_exists($booking->showtime, 'room')) {
                $booking->showtime->load('room');
            } elseif (method_exists($booking->showtime, 'sala')) {
                $booking->showtime->load('sala');
            }
        }

        return view('client.bookings.show', compact('booking'));
    }

    public function store(Request $request)
    {
        return back()->with('error', 'Funcionalidad en desarrollo');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'No tienes permisos para cancelar esta reserva.');
        }

        return back()->with('error', 'Funcionalidad en desarrollo');
    }
}
