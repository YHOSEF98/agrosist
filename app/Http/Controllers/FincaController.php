<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use App\Models\Empresa;
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
        $empresas = Empresa::all();
        return view('modules.finca.create', compact('empresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:fincas,nombre',
            'ubicacion' => 'required|string|max:255',
            'empresa_id' => 'required|exists:empresas,id',
        ], [
            'nombre.required' => 'El nombre de la finca es obligatorio.',
            'nombre.unique' => 'Ya existe una finca registrada con ese nombre.',
            'ubicacion.required' => 'La ubicación de la finca es obligatoria.',
            'empresa_id.required' => 'Debe seleccionar una empresa para asociar la finca.',
            'empresa_id.exists' => 'La empresa seleccionada no existe en el sistema.',
        ]);

        Finca::create([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'empresa_id' => $request->empresa_id,
        ]);

        return redirect()
            ->route('fincas')
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
    public function edit(string $id)
    {
        $empresas = Empresa::all();
        $finca = Finca::findOrFail($id);
        return view('modules.finca.create', compact('finca', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $finca = Finca::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:fincas,nombre,' . $finca->id,
            'ubicacion' => 'required|string|max:255',
            'empresa_id' => 'required|exists:empresas,id',
        ], [
            'nombre.required' => 'El nombre de la finca es obligatorio.',
            'nombre.unique' => 'Ya existe otra finca registrada con ese nombre.',
            'ubicacion.required' => 'La ubicación de la finca es obligatoria.',
            'empresa_id.required' => 'Debe seleccionar una empresa para asociar la finca.',
            'empresa_id.exists' => 'La empresa seleccionada no existe en el sistema.',
        ]);

        $finca->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'empresa_id' => $request->empresa_id,
        ]);

        return redirect()
            ->route('fincas')
            ->with('success', 'Finca actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $finca = Finca::findOrFail($id);
        $finca->delete();

        return redirect()
            ->route('fincas')
            ->with('success', 'Finca eliminada correctamente.');
    }
}
