<?php

namespace App\Http\Controllers;

use App\Models\ViajeFruto;
use Illuminate\Http\Request;

class ViajeFrutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viajes = ViajeFruto::all();
        return view('modules.viajes_fruto.index', compact('viajes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viaje = null;
        return view('modules.viajes_fruto.create', compact('viaje'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ViajeFruto $viajeFruto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, ViajeFruto $viajes_fruto)
    {
        $viaje=$viajes_fruto;
        return view('modules.viajes_fruto.create', compact('viaje'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $current_team, ViajeFruto $viajeFruto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, ViajeFruto $viajes_fruto)
    {
        $viajes_fruto->delete();
        return redirect()->route('viajes-fruto.index')->with('success', 'Viaje eliminado correctamente.');
    }
}
