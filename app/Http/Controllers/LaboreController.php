<?php

namespace App\Http\Controllers;

use App\Models\Labore;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class LaboreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labores = Labore::all();
        return view('modules.labores.index', compact('labores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $unidadesm = UnidadMedida::all();
        return view('modules.labores.create', compact('unidadesm'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'actividad' => 'required|string|max:255|unique:labores,actividad',
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'rendimiento_esperado' => 'required',
            'valor_unitario' => 'required',
            'tarifa_contratista' => 'nullable|decimal:0,2',
            'tarifa_personal_directo' => 'nullable|decimal:0,2',
            'valor_prestaciones' => 'nullable|decimal:0,2',
            'valor_total' => 'nullable|decimal:0,2',
            'observaciones' => 'nullable|string|max:255',
        ], [
            'actividad.required' => 'El nombre de la finca es obligatorio.',
            'valor_unitario.required' => 'valor por unidad de medida.',
            'actividad.unique' => 'Ya existe una finca registrada con ese nombre.',
            'rendimiento_esperado.required' => 'es necesario saber el rendimiento esperado.',
            'unidad_medida_id.required' => 'Debe seleccionar una unidad de medida.',
            'unidad_medida_id.exists' => 'La unidad de medida seleccionada no existe en el sistema.',
        ]);

        Labore::create([
            'actividad' => $request->actividad,
            'unidad_medida_id' => $request->unidad_medida_id,
            'rendimiento_esperado' => $request->rendimiento_esperado,
            'valor_unitario' => $request->valor_unitario,
            'tarifa_contratista' => $request->tarifa_contratista,
            'tarifa_personal_directo' => $request->tarifa_personal_directo,
            'valor_prestaciones' => $request->valor_prestaciones,
            'valor_total' => $request->valor_total,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('labores.index')
            ->with('success', 'Labor registrada correctamente.');
        }

    /**
     * Display the specified resource.
     */
    public function show(Labore $labore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $labor = Labore::findOrFail($id);
        $unidadesm = UnidadMedida::all();
        return view('modules.labores.create', compact('labor', 'unidadesm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $labore = Labore::findOrFail($id);
        $request->validate([
            'actividad' => 'required|string|max:255|unique:labores,actividad,' . $labore->id,
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'rendimiento_esperado' => 'required',
            'valor_unitario' => 'required',
            'tarifa_contratista' => 'nullable|decimal:0,2',
            'tarifa_personal_directo' => 'nullable|decimal:0,2',
            'valor_prestaciones' => 'nullable|decimal:0,2',
            'valor_total' => 'nullable|decimal:0,2',
            'observaciones' => 'nullable|string|max:255',
        ], [
            'actividad.required' => 'El nombre de la finca es obligatorio.',
            'valor_unitario.required' => 'valor por unidad de medida.',
            'actividad.unique' => 'Ya existe una finca registrada con ese nombre.',
            'rendimiento_esperado.required' => 'es necesario saber el rendimiento esperado.',
            'unidad_medida_id.required' => 'Debe seleccionar una unidad de medida.',
            'unidad_medida_id.exists' => 'La unidad de medida seleccionada no existe en el sistema.',
        ]);

        $labore->update([
            'actividad' => $request->actividad,
            'unidad_medida_id' => $request->unidad_medida_id,
            'rendimiento_esperado' => $request->rendimiento_esperado,
            'valor_unitario' => $request->valor_unitario,
            'tarifa_contratista' => $request->tarifa_contratista,
            'tarifa_personal_directo' => $request->tarifa_personal_directo,
            'valor_prestaciones' => $request->valor_prestaciones,
            'valor_total' => $request->valor_total,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('labores.index')
            ->with('success', 'Labor actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $labore = Labore::findOrFail($id);
        $labore->delete();

        return redirect()
            ->route('labores.index')
            ->with('success', 'Labor eliminada correctamente.');
    }
    
}
