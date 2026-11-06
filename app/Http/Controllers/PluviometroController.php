<?php

namespace App\Http\Controllers;

use App\Models\Pluviometro;
use App\Models\Finca;
use Illuminate\Http\Request;

class PluviometroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pluviometros = Pluviometro::all();
        return view('modules.pluviometro.index', compact('pluviometros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pluviometro = null;
        $fincas = Finca::all();
        return view('modules.pluviometro.create', compact('pluviometro', 'fincas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $current_team)
    {
        $validated = $request->validate([
            'finca_id' => 'required|exists:fincas,id',
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        Pluviometro::create($validated);

        return redirect()->route('pluviometros.index')
            ->with('success', 'Pluviometro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $current_team, Pluviometro $pluviometro)
    {
        return view('modules.pluviometro.show', compact('pluviometro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, Pluviometro $pluviometro)
    {
        $fincas = Finca::all();
        return view('modules.pluviometro.create', compact('pluviometro', 'fincas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Pluviometro $pluviometro)
    {
        $validated = $request->validate([
            'finca_id' => 'required|exists:fincas,id',
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $pluviometro->update($validated);

        return redirect()->route('pluviometros.index')
            ->with('success', 'Pluviometro actualizado exitosamente.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Pluviometro $pluviometro)
    {
        $pluviometro->delete();

        return redirect()->route('pluviometros.index')
            ->with('success', 'Pluviometro eliminado exitosamente.');
    }
}
