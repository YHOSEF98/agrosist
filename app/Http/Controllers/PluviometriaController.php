<?php

namespace App\Http\Controllers;

use App\Models\Pluviometria;
use App\Models\Pluviometro;
use Illuminate\Http\Request;

class PluviometriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pluviometrias = Pluviometria::all();
        return view('modules.pluviometria.index', compact('pluviometrias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pluviometros = Pluviometro::all();
        return view('modules.pluviometria.create', compact('pluviometros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pluviometro_id' => 'required|exists:pluviometros,id',
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric',
        ]);

        Pluviometria::create($request->all());

        return redirect()->route('pluviometria.index')
            ->with('success', 'Registro de pluviometría creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pluviometria $pluviometria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pluviometria = Pluviometria::findOrFail($id);
        $pluviometros = Pluviometro::all();
        return view('modules.pluviometria.create', compact('pluviometria', 'pluviometros'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pluviometria = Pluviometria::findOrFail($id);

        $request->validate([
            'pluviometro_id' => 'required|exists:pluviometros,id',
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric',
        ]);

        $pluviometria->update($request->all());

        return redirect()->route('pluviometria.index')
            ->with('success', 'Registro de pluviometría actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pluviometria = Pluviometria::findOrFail($id);
        $pluviometria->delete();

        return redirect()->route('pluviometria.index')
            ->with('success', 'Registro de pluviometría eliminado exitosamente.');
    }
}
