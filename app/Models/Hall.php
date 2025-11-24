<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity', // Asegúrate de que capacity esté aquí
        'type',
        'features',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    /**
     * Get the showtimes for the hall.
     */
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    /**
     * Check if the hall is available for a showtime
     */
    public function isAvailableForShowtime($startTime, $endTime)
    {
        return !$this->showtimes()
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            })
            ->exists();
    }

    /**
     * Scope a query to only include active halls.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
