<?php

namespace App\Http\Controllers;

use App\Models\RemisionFruto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Invfruta;

class RemisionFrutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $remisiones = RemisionFruto::all();
        return view('modules.remision.index', compact('remisiones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $remision = null; // Puedes pasar un objeto RemisionFruto existente si estás editando
        return view('modules.remision.create', compact('remision'));
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
    public function show(RemisionFruto $remisionFruto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, RemisionFruto $alce_fruto)
    {
        $remision = $alce_fruto;
        return view('modules.remision.create', compact('remision'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RemisionFruto $remisionFruto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $current_team, RemisionFruto $alce_fruto)
    {
        DB::transaction(function () use ($alce_fruto) {

            // 1. Bloquear y recuperar la remisión
            $remision = RemisionFruto::whereKey($alce_fruto->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Verificar que pertenezca al equipo actual
            abort_unless(
                (int) $remision->team_id === (int) Auth::user()->currentTeam->id,
                403
            );

            // 2. Obtener los detalles de la remisión
            $detalles = $remision->detalles()->get();

            // 3. Agrupar cantidades por inventario
            $detallesAgrupados = $detalles->groupBy('invfrutas_id');

            // 4. Obtener los IDs de inventario
            $idsInventario = $detallesAgrupados->keys()
                ->sort()
                ->values();

            // 5. Bloquear los registros de inventario
            $inventarios = Invfruta::whereIn('id', $idsInventario)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // 6. Devolver las cantidades al inventario
            foreach ($detallesAgrupados as $invfrutaId => $grupo) {

                $invfruta = $inventarios->get($invfrutaId);

                if (!$invfruta) {
                    throw new \Exception(
                        "No se encontró el inventario con ID {$invfrutaId}."
                    );
                }

                // Cantidad que esta remisión había cargado
                $cantidadAnterior = $grupo->sum('cantidad_cargada');

                // Devolver únicamente esa cantidad
                $invfruta->cantidad_cargada -= $cantidadAnterior;

                if ($invfruta->cantidad_cargada < 0) {
                    throw new \Exception(
                        "El inventario del lote {$invfruta->lote->nombre} presenta cantidades inconsistentes."
                    );
                }

                // Recalcular el estado
                $invfruta->cargado =
                    $invfruta->cantidad_cargada >= $invfruta->cantidad;

                $invfruta->save();
            }

            // 7. Eliminar los detalles de la remisión
            $remision->detalles()->delete();

            // 8. Eliminar la remisión
            $remision->delete();
        });

        session()->flash(
            'success',
            'Remisión eliminada correctamente y las cantidades fueron devueltas al inventario.'
        );

        return redirect()->route('alce-fruto.index');
    }
}
