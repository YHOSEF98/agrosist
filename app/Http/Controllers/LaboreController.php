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
        $labore= null;        
        $unidadesm = UnidadMedida::all();
        return view('modules.labores.create', compact('unidadesm', 'labore'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $current_team)
    {
        $validate = $request->validate([
            'actividad' => 'required|string|max:255|unique:labores,actividad',
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'rendimiento_esperado' => 'required|decimal:0,2',
            'valor_unitario' => 'required|decimal:0,2',
            'tarifa_contratista' => 'nullable|decimal:0,2',
            'tarifa_personal_directo' => 'nullable|decimal:0,2',
            'valor_prestaciones' => 'nullable|decimal:0,2',
            'valor_total' => 'nullable|decimal:0,2',
            'observaciones' => 'nullable|string|max:255',
            'invfruta' => 'nullable|boolean',
        ], [
            'actividad.required' => 'El nombre de la finca es obligatorio.',
            'valor_unitario.required' => 'valor por unidad de medida.',
            'actividad.unique' => 'Ya existe una finca registrada con ese nombre.',
            'rendimiento_esperado.required' => 'es necesario saber el rendimiento esperado.',
            'unidad_medida_id.required' => 'Debe seleccionar una unidad de medida.',
            'unidad_medida_id.exists' => 'La unidad de medida seleccionada no existe en el sistema.',
        ]);

        Labore::create($validate);

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
    public function edit(string $current_team, Labore $labore)
    {
        $unidadesm = UnidadMedida::all();
        return view('modules.labores.create', compact('labore', 'unidadesm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Labore $labore)
    {
        $validate = $request->validate([
            'actividad' => 'required|string|max:255|unique:labores,actividad,' . $labore->id,
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'rendimiento_esperado' => 'required',
            'valor_unitario' => 'required',
            'tarifa_contratista' => 'nullable|decimal:0,2',
            'tarifa_personal_directo' => 'nullable|decimal:0,2',
            'valor_prestaciones' => 'nullable|decimal:0,2',
            'valor_total' => 'nullable|decimal:0,2',
            'observaciones' => 'nullable|string|max:255',
            'invfruta' => 'nullable|boolean',
        ], [
            'actividad.required' => 'El nombre de la finca es obligatorio.',
            'valor_unitario.required' => 'valor por unidad de medida.',
            'actividad.unique' => 'Ya existe una finca registrada con ese nombre.',
            'rendimiento_esperado.required' => 'es necesario saber el rendimiento esperado.',
            'unidad_medida_id.required' => 'Debe seleccionar una unidad de medida.',
            'unidad_medida_id.exists' => 'La unidad de medida seleccionada no existe en el sistema.',
        ]);

        $labore->update($validate);

        return redirect()
            ->route('labores.index')
            ->with('success', 'Labor actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Labore $labore)
    {
        $labore->delete();

        return redirect()
            ->route('labores.index')
            ->with('success', 'Labor eliminada correctamente.');
    }
    
}
