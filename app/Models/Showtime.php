<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'room_id',
        'start_time',
        'end_time',
        'price',
        'available_seats',
        'is_active',
        'format',
        'language',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'price' => 'decimal:2',
        'available_seats' => 'integer',
        'is_active' => 'boolean',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_time', '>', now());
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_seats', '>', 0)
            ->where('is_active', true)
            ->where('start_time', '>', now()->addHours(1));
    }

    // Calcular asientos ocupados
    public function getOccupiedSeatsAttribute()
    {
        return $this->tickets()->whereIn('status', ['confirmed', 'reserved'])->count();
    }

    // Verificar si hay asientos disponibles
    public function hasAvailableSeats()
    {
        return $this->available_seats > $this->occupied_seats;
    }
}
