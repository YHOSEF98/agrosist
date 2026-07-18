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
        $fincas = Finca::all();
        return view('modules.lote.create', compact('fincas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
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

        Lote::create([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'cultivo' => $request->cultivo,
            'variedad' => $request->variedad,
            'peso_prom' => $request->peso_prom,
            'finca_id' => $request->finca_id,
        ]);

        return redirect()
            ->route('lotes')
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
    public function edit(string $id)
    {
        $lote = Lote::findOrFail($id);
        $fincas = Finca::all();
        return view('modules.lote.create', compact('lote', 'fincas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lote = Lote::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:lotes,nombre,' . $lote->id,
            'ubicacion' => 'nullable|string|max:255',
            'cultivo' => 'nullable|string|max:255',
            'variedad' => 'nullable|string|max:255',
            'peso_prom' => 'nullable|numeric|min:0',
            'finca_id' => 'required|exists:fincas,id',
        ]);

        $lote->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'cultivo' => $request->cultivo,
            'variedad' => $request->variedad,
            'peso_prom' => $request->peso_prom,
            'finca_id' => $request->finca_id,
        ]);

        return redirect()
            ->route('lotes')
            ->with('success', 'Lote actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lote = Lote::findOrFail($id);
        $lote->delete();

        return redirect()
            ->route('lotes')
            ->with('success', 'Lote eliminado correctamente.');
    }
}
