<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtime_id',
        'seats',
        'total_price',
        'booking_date',
        'status',
        'is_active',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'seats' => 'array',
        'total_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the showtime that owns the booking.
     */
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    /**
     * Scope a query to only include active bookings.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
