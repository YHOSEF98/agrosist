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
        $fincas = Finca::all();
        return view('modules.acopio.create', compact('fincas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:acopios,nombre',
            'estado' => 'nullable|boolean',
            'finca_id' => 'required|exists:fincas,id',
        ], [
            'nombre.required' => 'El nombre del acopio es obligatorio.',
            'nombre.unique' => 'Ya existe un acopio registrado con ese nombre.',
            'finca_id.required' => 'La finca es obligatoria.',
            'finca_id.exists' => 'La finca seleccionada no es válida.',
        ]);

        Acopio::create([
            'nombre' => $request->nombre,
            'estado' => $request->estado ?? true,
            'finca_id' => $request->finca_id,
        ]);

        return redirect()
            ->route('acopios')
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
    public function edit(string $id)
    {
        $acopio = Acopio::findOrFail($id);
        return view('modules.acopio.create', compact('acopio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $acopio = Acopio::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:255|unique:acopios,nombre,' . $acopio->id,
            'estado' => 'nullable|boolean',
            'finca_id' => 'required|exists:fincas,id',
        ], [
            'nombre.required' => 'El nombre del acopio es obligatorio.',
            'nombre.unique' => 'Ya existe un acopio registrado con ese nombre.',
        ]);

        $acopio->update([
            'nombre' => $request->nombre,
            'estado' => $request->estado ?? true,
            'finca_id' => $request->finca_id,
        ]);

        return redirect()
            ->route('acopios')
            ->with('success', 'Acopio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $acopio = Acopio::findOrFail($id);
        $acopio->delete();

        return redirect()
            ->route('acopios')
            ->with('success', 'Acopio eliminado correctamente.');
    }
}
