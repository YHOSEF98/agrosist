<?php

namespace App\Http\Controllers;

use App\Models\Cuadrilla;
use App\Models\Labore;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuadrillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuadrillas = Cuadrilla::all();
        return view('modules.cuadrilla.index', compact('cuadrillas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labores = Labore::all();
        $trabajadores = Trabajador::all();
        return view('modules.cuadrilla.create', compact('labores', 'trabajadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación básica de la cuadrilla
        $request->validate([
            'fecha' => 'required|date',
            'nombre' => 'required|string|max:255',
            'labore_id' => 'required|exists:labores,id',
            'observacion' => 'nullable|string',
            'trabajadores' => 'required|array|min:1',
            'trabajadores.*' => 'exists:trabajadores,id',
        ]);

        // Validar que cada trabajador no esté ya asignado en esa fecha
        foreach ($request->trabajadores as $trabajadorId) {
            $existe = DB::table('cuadrilla_trabajador')
                ->where('trabajador_id', $trabajadorId)
                ->where('fecha', $request->fecha)
                ->exists();

            if ($existe) {
                return back()->withErrors([
                    'error' => "El trabajador con ID {$trabajadorId} ya está asignado a otra cuadrilla en la fecha {$request->fecha}"
                ]);
            }
        }

        // Crear la cuadrilla
        $cuadrilla = Cuadrilla::create([
            'fecha' => $request->fecha,
            'nombre' => $request->nombre,
            'labore_id' => $request->labore_id,
            'observacion' => $request->observacion,
        ]);

        // Asignar trabajadores a la cuadrilla (tabla intermedia)
        foreach ($request->trabajadores as $trabajador) {
        $cuadrilla->trabajadores()->attach($trabajador['id'], [
            'fecha' => $request->fecha
        ]);
    }

        return redirect()->route('cuadrillas.index')
            ->with('success', 'Cuadrilla creada y trabajadores asignados correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuadrilla $cuadrilla)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $labores = Labore::all();
        $cuadrilla = Cuadrilla::with('trabajadores')->findOrFail($id);
        return view('modules.cuadrilla.create', compact('cuadrilla', 'labores', 'cuadrilla'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación básica
        $request->validate([
            'fecha' => 'required|date',
            'nombre' => 'required|string|max:255',
            'labore_id' => 'required|exists:labores,id',
            'observacion' => 'nullable|string',
            'trabajadores' => 'required|array|min:1',
            'trabajadores.*' => 'exists:trabajadores,id',
        ]);

        $cuadrilla = Cuadrilla::findOrFail($id);

        // Validar que cada trabajador no esté ya asignado en esa fecha a otra cuadrilla
        foreach ($request->trabajadores as $trabajadorId) {
            $existe = DB::table('cuadrilla_trabajador')
                ->where('trabajador_id', $trabajadorId)
                ->where('fecha', $request->fecha)
                ->where('cuadrilla_id', '!=', $cuadrilla->id) // importante: excluir la misma cuadrilla
                ->exists();

            if ($existe) {
                return back()->withErrors([
                    'error' => "El trabajador con ID {$trabajadorId} ya está asignado a otra cuadrilla en la fecha {$request->fecha}"
                ]);
            }
        }

        // Actualizar datos de la cuadrilla
        $cuadrilla->update([
            'fecha' => $request->fecha,
            'nombre' => $request->nombre,
            'labore_id' => $request->labore_id,
            'observacion' => $request->observacion,
        ]);

        // Actualizar trabajadores en la tabla intermedia
        $syncData = [];
        foreach ($request->trabajadores as $trabajadorId) {
            $syncData[$trabajadorId] = ['fecha' => $request->fecha];
        }

        $cuadrilla->trabajadores()->sync($syncData);

        return redirect()->route('cuadrillas.index')
            ->with('success', 'Cuadrilla actualizada y trabajadores asignados correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuadrilla $cuadrilla)
    {
        //
    }
}
