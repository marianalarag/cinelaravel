<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::latest()->get();
        return view('admin.halls.index', compact('halls'));
    }

    public function create()
    {
        return view('admin.halls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:standard,imax,4dx',
            'features' => 'nullable|string',
        ]);

        Hall::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'type' => $request->type,
            'features' => $request->features,
            'is_active' => true,
        ]);

        return redirect()->route('admin.halls.index')
            ->with('success', 'Sala creada correctamente.');
    }

    public function show(Hall $hall)
    {
        return view('admin.halls.show', compact('hall'));
    }

    public function edit(Hall $hall)
    {
        return view('admin.halls.edit', compact('hall'));
    }

    public function update(Request $request, Hall $hall)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:standard,imax,4dx',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $hall->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'type' => $request->type,
            'features' => $request->features,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.halls.index')
            ->with('success', 'Sala actualizada correctamente.');
    }

    public function destroy(Hall $hall)
    {
        $hall->delete();

        return redirect()->route('admin.halls.index')
            ->with('success', 'Sala eliminada correctamente.');
    }

    public function toggleStatus(Hall $hall)
    {
        $hall->update(['is_active' => !$hall->is_active]);

        $status = $hall->is_active ? 'activada' : 'desactivada';
        return redirect()->route('admin.halls.index')
            ->with('success', "Sala {$status} correctamente.");
    }
}
