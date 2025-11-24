<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('movies')->latest()->get();
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        Genre::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.genres.index')
            ->with('success', 'Género creado correctamente.');
    }

    public function show(Genre $genre)
    {
        $genre->loadCount('movies');
        return view('admin.genres.show', compact('genre'));
    }

    public function edit(Genre $genre)
    {
        $genre->loadCount('movies');
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $genre->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.genres.index')
            ->with('success', 'Género actualizado correctamente.');
    }

    public function destroy(Genre $genre)
    {
        // Verificar si hay películas asociadas
        if ($genre->movies()->exists()) {
            return redirect()->route('admin.genres.index')
                ->with('error', 'No se puede eliminar el género porque tiene películas asociadas.');
        }

        $genre->delete();

        return redirect()->route('admin.genres.index')
            ->with('success', 'Género eliminado correctamente.');
    }

    public function toggleStatus(Genre $genre)
    {
        $genre->update(['is_active' => !$genre->is_active]);

        $status = $genre->is_active ? 'activado' : 'desactivado';
        return redirect()->route('admin.genres.index')
            ->with('success', "Género {$status} correctamente.");
    }

    /**
     * Get movies by genre
     */
    public function movies(Genre $genre)
    {
        $movies = $genre->movies()->with('showtimes')->latest()->get();
        return view('admin.genres.movies', compact('genre', 'movies'));
    }

    /**
     * Search genres
     */
    public function search(Request $request)
    {
        $search = $request->get('search');

        $genres = Genre::withCount('movies')
            ->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->latest()
            ->get();

        return view('admin.genres.index', compact('genres', 'search'));
    }
}
