<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class ClientMovieController extends Controller
{
    /**
     * Display a listing of all movies.
     */
    public function index()
    {
        $movies = Movie::where('is_active', true)
            ->orderBy('release_date', 'desc')
            ->paginate(12);

        return view('client.movies.index', compact('movies'));
    }

    /**
     * Display movies currently showing.
     */
    public function nowShowing()
    {
        $movies = Movie::where('is_active', true)
            ->where('release_date', '<=', now()) // Solo películas ya estrenadas
            ->orderBy('release_date', 'desc')
            ->paginate(12);

        return view('client.movies.now-showing', compact('movies'));
    }

    /**
     * Display coming soon movies.
     */
    public function comingSoon()
    {
        $movies = Movie::where('is_active', true)
            ->where('release_date', '>', now()) // Solo películas por estrenar
            ->orderBy('release_date', 'asc')
            ->paginate(12);

        return view('client.movies.coming-soon', compact('movies'));
    }

    /**
     * Display the specified movie.
     */
    public function show(Movie $movie)
    {
        // Verificar que la película esté activa
        if (!$movie->is_active) {
            abort(404);
        }

        // Cargar showtimes activos
        $movie->load(['showtimes' => function($query) {
            $query->where('start_time', '>', now())
                ->where('is_active', true)
                ->orderBy('start_time');
        }]);

        return view('client.movies.show', compact('movie'));
    }

    /**
     * Display showtimes for a specific movie.
     */
    public function showtimes(Movie $movie)
    {
        // Verificar que la película esté activa
        if (!$movie->is_active) {
            abort(404);
        }

        $movie->load(['showtimes' => function($query) {
            $query->where('start_time', '>', now())
                ->where('is_active', true)
                ->with('hall')
                ->orderBy('start_time');
        }]);

        return view('client.movies.showtimes', compact('movie'));
    }
}
