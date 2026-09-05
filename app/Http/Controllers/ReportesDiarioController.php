<?php

namespace App\Http\Controllers;

use App\Models\ReportesDiario;
use App\Models\Labore;
use App\Models\Lote;
use App\Models\Acopio;
use Illuminate\Http\Request;

class ReportesDiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reportesDiarios = ReportesDiario::all();
        return view('modules.reporte_diario.index', compact('reportesDiarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lotes = Lote::all();
        $acopios = Acopio::all();
        $labores = Labore::all();
        return view('modules.reporte_diario.create', compact('labores', 'lotes', 'acopios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('modules.reporte_diario.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReportesDiario $reportesDiario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    // Buscar el reporte por ID
    $reporte = ReportesDiario::with(['cuadrilla', 'detalles'])->findOrFail($id);

    // Traer las colecciones necesarias para los selects
    $lotes = Lote::all();
    $acopios = Acopio::all();
    $labores = Labore::all();

    // Retornar la vista de edición con los datos cargados
    return view('modules.reporte_diario.create', compact('reporte', 'labores', 'lotes', 'acopios'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportesDiario $reportesDiario)
    {
        return view('modules.reporte_diario.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportesDiario $reportesDiario)
    {
        //
    }
}
