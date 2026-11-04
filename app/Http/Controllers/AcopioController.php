<?php

namespace App\Http\Controllers;

use App\Models\Acopio;
use App\Models\Finca;
use Illuminate\Http\Request;

class AcopioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acopios = Acopio::all();
        return view('modules.acopio.index', compact('acopios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $acopio = null;
        $fincas = Finca::all();
        return view('modules.acopio.create', compact('acopio', 'fincas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $current_team)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:acopios,nombre',
            'estado' => 'nullable|boolean',
            'finca_id' => 'required|exists:fincas,id',
        ], [
            'nombre.required' => 'El nombre del acopio es obligatorio.',
            'nombre.unique' => 'Ya existe un acopio registrado con ese nombre.',
            'finca_id.required' => 'La finca es obligatoria.',
            'finca_id.exists' => 'La finca seleccionada no es válida.',
        ]);

        Acopio::create($validated);

        return redirect()
            ->route('acopios.index')
            ->with('success', 'Acopio registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Acopio $acopio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, Acopio $acopio)
    {
        $fincas = Finca::all();
        return view('modules.acopio.create', compact('acopio', 'fincas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Acopio $acopio)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:acopios,nombre,' . $acopio->id,
            'estado' => 'nullable|boolean',
            'finca_id' => 'required|exists:fincas,id',
        ], [
            'nombre.required' => 'El nombre del acopio es obligatorio.',
            'nombre.unique' => 'Ya existe un acopio registrado con ese nombre.',
        ]);

        $acopio->update($validated);

        return redirect()
            ->route('acopios.index')
            ->with('success', 'Acopio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Acopio $acopio)
    {
        $acopio->delete();

        return redirect()
            ->route('acopios.index')
            ->with('success', 'Acopio eliminado correctamente.');
    }
}
