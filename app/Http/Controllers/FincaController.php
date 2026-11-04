<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use App\Models\Team;
use Illuminate\Http\Request;

class FincaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fincas = Finca::all();
        return view('modules.finca.index', compact('fincas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $finca = null; // No hay finca existente al crear una nueva
        $teams = Team::all();
        return view('modules.finca.create', compact('finca', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
        ], [
            'nombre.required' => 'El nombre de la finca es obligatorio.',
            'ubicacion.required' => 'La ubicación de la finca es obligatoria.',
            'team_id.required' => 'Debe seleccionar un equipo para asociar la finca.',
            'team_id.exists' => 'El equipo seleccionado no existe en el sistema.',
        ]);

        Finca::create([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'team_id' => $request->team_id,
        ]);

        return redirect()
            ->route('fincas.index')
            ->with('success', 'Finca registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Finca $finca)
    {
        $finca = Finca::findOrFail($finca->id);
        return view('modules.finca.show', compact('finca'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, Finca $finca)
    {
        $teams = Team::all();
        return view('modules.finca.create', compact('finca', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Finca $finca)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
        ], [
            'nombre.required' => 'El nombre de la finca es obligatorio.',
            'ubicacion.required' => 'La ubicación de la finca es obligatoria.',
            'team_id.required' => 'Debe seleccionar un equipo para asociar la finca.',
            'team_id.exists' => 'El equipo seleccionado no existe en el sistema.',
        ]);

        $finca->update($validated);

        return redirect()
            ->route('fincas.index')
            ->with('success', 'Finca actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Finca $finca)
    {
        $finca = Finca::findOrFail($finca->id);
        $finca->delete();

        return redirect()
            ->route('fincas.index')
            ->with('success', 'Finca eliminada correctamente.');
    }
}
