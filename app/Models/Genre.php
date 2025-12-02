<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class  Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'movies_count',
        'active_movies_count',
        'now_showing_count',
    ];

    /**
     * Get the movies for the genre.
     * Relación basada en el campo 'genre' (string) de la tabla movies
     */
    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class, 'genre', 'name');
    }

    /**
     * Get active movies for the genre.
     */
    public function activeMovies(): HasMany
    {
        return $this->movies()->active();
    }

    /**
     * Get now showing movies for the genre.
     */
    public function nowShowingMovies(): HasMany
    {
        return $this->movies()->nowShowing();
    }

    /**
     * Get total movies count for the genre.
     */
    public function getMoviesCountAttribute(): int
    {
        if (array_key_exists('movies_count', $this->attributes)) {
            return $this->attributes['movies_count'];
        }

        return $this->movies()->count();
    }

    /**
     * Get active movies count for the genre.
     */
    public function getActiveMoviesCountAttribute(): int
    {
        return $this->activeMovies()->count();
    }

    /**
     * Get now showing movies count for the genre.
     */
    public function getNowShowingCountAttribute(): int
    {
        return $this->nowShowingMovies()->count();
    }

    /**
     * Check if genre has any movies.
     */
    public function hasMovies(): bool
    {
        return $this->movies_count > 0;
    }

    /**
     * Check if genre has active movies.
     */
    public function hasActiveMovies(): bool
    {
        return $this->active_movies_count > 0;
    }

    /**
     * Scope a query to only include active genres.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive genres.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope a query to only include genres with movies.
     */
    public function scopeWithMovies($query)
    {
        return $query->has('movies');
    }

    /**
     * Scope a query to only include genres without movies.
     */
    public function scopeWithoutMovies($query)
    {
        return $query->doesntHave('movies');
    }

    /**
     * Scope a query to only include genres with active movies.
     */
    public function scopeWithActiveMovies($query)
    {
        return $query->whereHas('movies', function($q) {
            $q->active();
        });
    }

    /**
     * Scope a query to search genres by name or description.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Scope a query to order by movies count.
     */
    public function scopeOrderByMoviesCount($query, string $direction = 'desc')
    {
        return $query->withCount('movies')->orderBy('movies_count', $direction);
    }

    /**
     * Activate the genre.
     */
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Deactivate the genre.
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * Toggle the active status of the genre.
     */
    public function toggleStatus(): bool
    {
        return $this->update(['is_active' => !$this->is_active]);
    }

    /**
     * Check if genre can be deleted.
     */
    public function canBeDeleted(): bool
    {
        return !$this->hasMovies();
    }

    /**
     * Get the display name with movie count.
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} ({$this->movies_count})";
    }

    /**
     * Get a short description.
     */
    public function getShortDescriptionAttribute(): string
    {
        if (!$this->description) {
            return 'Sin descripción';
        }

        return strlen($this->description) > 100
            ? substr($this->description, 0, 100) . '...'
            : $this->description;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Prevent deletion if genre has movies
        static::deleting(function ($genre) {
            if ($genre->movies()->exists()) {
                throw new \Exception('No se puede eliminar el género porque tiene películas asociadas.');
            }
        });

        // Convert name to title case when saving
        static::saving(function ($genre) {
            $genre->name = ucwords(strtolower($genre->name));
        });
    }
}
