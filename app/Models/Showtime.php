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
        'format', // Mantener como format en la base de datos
        'language',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the movie for the showtime.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get the room for the showtime.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the bookings for the showtime.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope a query to only include active showtimes.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
