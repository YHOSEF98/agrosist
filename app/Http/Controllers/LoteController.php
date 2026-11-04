<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Finca;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lotes = Lote::all();
        return view('modules.lote.index', compact('lotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lote = null; // No hay lote existente al crear uno nuevo.
        $fincas = Finca::all();
        return view('modules.lote.create', compact('lote', 'fincas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $current_team, Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:lotes,nombre',
            'ubicacion' => 'nullable|string|max:255',
            'cultivo' => 'nullable|string|max:255',
            'variedad' => 'nullable|string|max:255',
            'peso_prom' => 'nullable|numeric|min:0',
            'finca_id' => 'required|exists:fincas,id',
        ], [
            'nombre.required' => 'El nombre del lote es obligatorio.',
            'nombre.unique' => 'Ya existe un lote registrado con ese nombre.',
        ]);

        Lote::create($validated);

        return redirect()
            ->route('lotes.index')
            ->with('success', 'Lote registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lote $lote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, Lote $lote)
    {
        $fincas = Finca::all();
        return view('modules.lote.create', compact('lote', 'fincas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Lote $lote)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:lotes,nombre,' . $lote->id,
            'ubicacion' => 'nullable|string|max:255',
            'cultivo' => 'nullable|string|max:255',
            'variedad' => 'nullable|string|max:255',
            'peso_prom' => 'nullable|numeric|min:0',
            'finca_id' => 'required|exists:fincas,id',
        ]);

        $lote->update($validated);

        return redirect()
            ->route('lotes.index')
            ->with('success', 'Lote actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lote $lote, string $current_team)
    {
        $lote->delete();

        return redirect()
            ->route('lotes.index')
            ->with('success', 'Lote eliminado correctamente.');
    }
}
