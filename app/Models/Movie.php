<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'genre',
        'director',
        'cast',
        'rating',
        'poster_url',
        'trailer_url',
        'is_active',
        'release_date',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
        'release_date' => 'date',
        'duration' => 'integer',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    // Scope para películas activas
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope para películas en cartelera
    public function scopeNowShowing($query)
    {
        return $query->where('release_date', '<=', now())
            ->where('is_active', true);
    }
}
