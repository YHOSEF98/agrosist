<?php

namespace App\Http\Controllers;

use App\Models\Pluviometria;
use App\Models\Pluviometro;
use Illuminate\Http\Request;

class PluviometriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pluviometrias = Pluviometria::all();
        return view('modules.pluviometria.index', compact('pluviometrias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pluviometria = null;
        $pluviometros = Pluviometro::all();
        return view('modules.pluviometria.create', compact('pluviometros', 'pluviometria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $current_team)
    {
        $validated = $request->validate([
            'pluviometro_id' => 'required|exists:pluviometros,id',
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric',
        ]);

        Pluviometria::create($validated);

        return redirect()->route('pluviometria.index')
            ->with('success', 'Registro de pluviometría creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pluviometria $pluviometria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, Pluviometria $pluviometria)
    {
        $pluviometros = Pluviometro::all();
        return view('modules.pluviometria.create', compact('pluviometria', 'pluviometros'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Pluviometria $pluviometria)
    {
        $validated = $request->validate([
            'pluviometro_id' => 'required|exists:pluviometros,id',
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric',
        ]);

        $pluviometria->update($validated);

        return redirect()->route('pluviometria.index')
            ->with('success', 'Registro de pluviometría actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Pluviometria $pluviometria)
    {
        $pluviometria->delete();

        return redirect()->route('pluviometria.index')
            ->with('success', 'Registro de pluviometría eliminado exitosamente.');
    }
}
