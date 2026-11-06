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
        $conductore = null;
        $proveedores = \App\Models\Provedore::all();
        $tiposDocumentos = \App\Models\TiposDocumento::all();
        return view('modules.conductores.create', compact('conductore', 'proveedores', 'tiposDocumentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $current_team)
    {
        try {
            // 1. Validar los datos que vienen del formulario
            $validated =$request->validate([
                'provedore_id' => 'required|exists:provedores,id',
                'tipo_documento_id' => 'required|exists:tipos_documentos,id',
                'numero_documento' => 'required|integer',
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'placa' => 'nullable|string|max:20',
            ], [
                // Mensajes personalizados en español
                'nombres.required' => 'El nombre del conductor es obligatorio.',
                'apellidos.required' => 'El apellido del conductor es obligatorio.',
                'numero_documento.required' => 'El número de documento es obligatorio.',
                'tipo_documento_id.required' => 'Debe seleccionar un tipo de documento.',
                'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',
                'provedore_id.required' => 'Debe seleccionar un proveedor.',
                'provedore_id.exists' => 'El proveedor seleccionado no es válido.',
            ]);

            // 2. Crear el registro en la base de datos
            Conductore::create($validated);

            // 3. Redirigir a la lista de conductores con un mensaje de éxito
            return redirect()->route('conductores.index')->with('success', 'Conductor creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('conductores.index', [
                    'current_team' => $current_team
                ])
                ->with('warning', $e->getMessage());
        }
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
    public function edit(string $current_team, Conductore $conductore)
    {
        $proveedores = \App\Models\Provedore::all();
        $tiposDocumentos = \App\Models\TiposDocumento::all();
        return view('modules.conductores.create', compact('conductore', 'proveedores', 'tiposDocumentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Conductore $conductore)
    {
        // 1. Validar los datos que vienen del formulario
        $validated = $request->validate([
            'provedore_id' => 'required|exists:provedores,id',
            'tipo_documento_id' => 'required|exists:tipos_documentos,id',
            'numero_documento' => 'required|integer',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'placa' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
        ], [
            // Mensajes personalizados en español
            'nombres.required' => 'El nombre del conductor es obligatorio.',
            'apellidos.required' => 'El apellido del conductor es obligatorio.',
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'tipo_documento_id.required' => 'Debe seleccionar un tipo de documento.',
            'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',
            'provedore_id.required' => 'Debe seleccionar un proveedor.',
            'provedore_id.exists' => 'El proveedor seleccionado no es válido.',
        ]);

        // 2. Actualizar el registro en la base de datos
        $conductore->update($validated);

        // 3. Redirigir a la lista de conductores con un mensaje de éxito
        return redirect()->route('conductores.index')->with('success', 'Conductor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Conductore $conductore)
    {
        $conductore->delete();

        return redirect()->route('conductores.index')->with('success', 'Conductor eliminado exitosamente.');
    }
}
