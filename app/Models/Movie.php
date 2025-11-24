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

    /**
     * Get the genre relation.
     * Relación basada en el campo 'genre' (string) con la tabla genres
     */
    public function genreRelation()
    {
        return $this->belongsTo(Genre::class, 'genre', 'name');
    }

    /**
     * Get movies by genre name.
     */
    public function scopeByGenre($query, $genreName)
    {
        return $query->where('genre', $genreName);
    }

    /**
     * Get movies with genre relation.
     */
    public function scopeWithGenre($query)
    {
        return $query->with('genreRelation');
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

    /**
     * Get the genre name with fallback.
     */
    public function getGenreNameAttribute()
    {
        return $this->genreRelation ? $this->genreRelation->name : $this->genre;
    }

    /**
     * Check if movie belongs to a specific genre.
     */
    public function hasGenre($genreName)
    {
        return $this->genre === $genreName;
    }
}
