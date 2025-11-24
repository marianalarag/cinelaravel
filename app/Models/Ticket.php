<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'showtime_id',
        'user_id',
        'seat_number',
        'seat_row',
        'price',
        'ticket_code',
        'status',
        'purchased_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'seat_number' => 'integer',
        'purchased_at' => 'datetime',
    ];

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    // Generar código único de ticket
    public static function generateTicketCode()
    {
        do {
            $code = 'TKT' . strtoupper(Str::random(8));
        } while (self::where('ticket_code', $code)->exists());

        return $code;
    }

    // Información del asiento
    public function getSeatInfoAttribute()
    {
        return $this->seat_row . $this->seat_number;
    }
}
