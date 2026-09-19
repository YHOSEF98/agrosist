<?php

namespace App\Http\Controllers;

use App\Models\Conductore;
use Illuminate\Http\Request;

class ConductoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conductores = Conductore::all();
        return view('modules.conductores.index', compact('conductores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = \App\Models\Provedore::all();
        return view('modules.conductores.create', compact('proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos que vienen del formulario
        $request->validate([
            'provedore_id' => 'required|exists:provedores,id',
            'tipo_documento' => 'required|string|max:30',
            'documento' => 'required|integer',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20',
        ], [
            // Mensajes personalizados en español
            'nombres.required' => 'El nombre del conductor es obligatorio.',
            'apellidos.required' => 'El apellido del conductor es obligatorio.',
            'documento.required' => 'El número de documento es obligatorio.',
            'provedore_id.required' => 'Debe seleccionar un proveedor.',
            'provedore_id.exists' => 'El proveedor seleccionado no es válido.',
        ]);

        // 2. Crear el registro en la base de datos
        Conductore::create([
            'provedore_id' => $request->provedore_id,
            'tipo_documento' => $request->tipo_documento,
            'documento' => $request->documento,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'placa' => $request->placa,
        ]);

        // 3. Redirigir a la lista de conductores con un mensaje de éxito
        return redirect()->route('conductores.index')->with('success', 'Conductor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Conductore $conductore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $conductor = Conductore::findOrFail($id);
        $proveedores = \App\Models\Provedore::all();
        return view('modules.conductores.create', compact('conductor', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $conductore = Conductore::findOrFail($id);

        // 1. Validar los datos que vienen del formulario
        $request->validate([
            'provedore_id' => 'required|exists:provedores,id',
            'tipo_documento' => 'required|string|max:30',
            'documento' => 'required|integer',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20',
        ], [
            // Mensajes personalizados en español
            'nombres.required' => 'El nombre del conductor es obligatorio.',
            'apellidos.required' => 'El apellido del conductor es obligatorio.',
            'documento.required' => 'El número de documento es obligatorio.',
            'provedore_id.required' => 'Debe seleccionar un proveedor.',
            'provedore_id.exists' => 'El proveedor seleccionado no es válido.',
        ]);

        // 2. Actualizar el registro en la base de datos
        $conductore->update([
            'provedore_id' => $request->provedore_id,
            'tipo_documento' => $request->tipo_documento,
            'documento' => $request->documento,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'placa' => $request->placa,
        ]);

        // 3. Redirigir a la lista de conductores con un mensaje de éxito
        return redirect()->route('conductores.index')->with('success', 'Conductor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $conductor = Conductore::findOrFail($id);
        $conductor->delete();

        return redirect()->route('conductores.index')->with('success', 'Conductor eliminado exitosamente.');
    }
}
