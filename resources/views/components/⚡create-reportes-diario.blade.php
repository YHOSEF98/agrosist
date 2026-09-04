<?php

use Livewire\Component;
use App\Models\ReportesDiario;
use App\Models\Cuadrilla;

new class extends Component
{
    public $action, $isEdit, $reporte, $labores, $lotes, $acopios,$fecha;
    public $loteSeleccionado, $acopioSeleccionado, $lineasSeleccionadas, $cantidadSeleccionada, $laborSeleccionada, $cuadrillaSeleccionada;
    public $acopioSeleccionadoId, $loteSeleccionadoId;
    public $laborNombre;
    public $detalles = [];
    public $cuadrillas = [];


    protected $listeners = ['fechaActualizada'];

    public function fechaActualizada($fecha)
    {
        $this->fecha = $fecha;
        // 1. Obtener IDs de cuadrillas ya reportadas en esa fecha
        $cuadrillasReportadas = ReportesDiario::whereDate('fecha', $this->fecha)
            ->pluck('cuadrilla_id');

        // 2. Traer cuadrillas creadas en esa fecha que NO estén reportadas
       $this->cuadrillas = Cuadrilla::with(['labor','trabajadores'])
            ->whereDate('fecha', $this->fecha)
            ->whereNotIn('id', $cuadrillasReportadas)
            ->get();
    }

    public function updatedCuadrillaSeleccionada($cuadrillaId)
    {
        if (empty($cuadrillaId)) {
            $this->laborNombre = '';
            $this->laborSeleccionada = null;
            return;
        }

        $cuadrilla = Cuadrilla::with('labor')->find($cuadrillaId);

        if ($cuadrilla && $cuadrilla->labor) {
            $this->laborNombre = $cuadrilla->labor->actividad;
            $this->laborSeleccionada = $cuadrilla->labor->id;
        } else {
            $this->laborNombre = '';
            $this->laborSeleccionada = null;
        }
    }


    public function agregarDetalle()
    {
        $this->detalles[] = [
            'lote_id' => $this->loteSeleccionado,
            'acopio_id' => $this->acopioSeleccionado,
            'linea' => $this->lineasSeleccionadas,
            'cantidad' => $this->cantidadSeleccionada,
        ];
        // limpiar campos del modal
        $this->reset(['loteSeleccionado','acopioSeleccionado','lineasSeleccionadas','cantidadSeleccionada']);
    }

    public function eliminarDetalle($index)
    {
        unset($this->detalles[$index]);
        $this->detalles = array_values($this->detalles); // Reindexar el array
    }
};
?>

<div class="card-body">

                        <form action="{{ $action }}" method="POST">
                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif
                            <!-- Fecha y nombre -->

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" wire:model="fecha"
                                    class="form-control @error('fecha') is-invalid @enderror"
                                    value="{{ old('fecha', $reporte->fecha ?? '') }}"
                                    onchange="Livewire.dispatch('fechaActualizada', { fecha: this.value })">
                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                </div>
                                <!-- cuadrilla asociada -->
                                <div class="col-md-4 mb-3">
                                <label for="cuadrilla_id" class="form-label">Cuadrilla</label>
                                <select
                                    id="cuadrilla_id"
                                    name="cuadrilla_id"
                                    wire:model.live="cuadrillaSeleccionada"
                                    class="form-select @error('cuadrilla_id') is-invalid @enderror"
                                >
                                    <option value="">Seleccione...</option>

                                    @foreach ($cuadrillas as $cuadrilla)
                                        <option value="{{ $cuadrilla->id }}">
                                            {{ $cuadrilla->nombre }}

                                            @if($cuadrilla->trabajadores->isNotEmpty())
                                                - [{{ $cuadrilla->trabajadores->pluck('nombres')->join(', ') }}]
                                            @else
                                                - [Sin trabajadores]
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                                <!-- Labor asociada -->
                            <div class="col-md-4 mb-3">
                            <label for="labor_nombre" class="form-label">Labor</label>
                            <input type="text" id="labor_nombre" class="form-control" wire:model="laborNombre" readonly>
                            <!-- Campo oculto para enviar el ID real -->
                            <input type="hidden" name="labore_id" value="{{ $laborSeleccionada }}">
                            @error('labore_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                            </div>

                            <!-- Observación -->
                            <div class="mb-3">
                                <label for="observacion" class="form-label">Observación</label>
                                <textarea id="observacion" name="observacion"
                                    class="form-control @error('observacion') is-invalid @enderror">{{ old('observacion', $reporte->observacion ?? '') }}</textarea>
                                @error('observacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card mb-4">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Detalle del registro diario</h3>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                        <i class="bi bi-plus"></i> Añadir registro
                    </button>
                </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table table-striped" role="table">
                      <thead>
                        <tr>
                          <th style="width: 10px" scope="col">#</th>
                          <th scope="col">Lote</th>
                          <th scope="col">Acopio</th>
                          <th scope="col">Lineas</th>
                          <th scope="col">Cantidad</th>
                          <th style="width: 40px" scope="col">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lotes->find($detalle['lote_id'])->nombre ?? 'N/A' }}</td>
                                <td>{{ $acopios->find($detalle['acopio_id'])->nombre ?? 'N/A' }}</td>
                                <td>{{ $detalle['linea'] }}</td>
                                <td>{{ $detalle['cantidad'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" wire:click="eliminarDetalle({{ $loop->index }})">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <!-- Modal -->
                <div wire:ignore.self class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegistroLabel">Añadir registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        <label for="lote_id" class="form-label">Lote</label>
                        <select id="lote_id" class="form-select" wire:model="loteSeleccionado">
                            <option value="">Seleccione...</option>
                            @foreach ($lotes as $lote)
                                <option value="{{ $lote->id }}">{{ $lote->nombre }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="mb-3">
                        <label for="acopio_id" class="form-label">Acopios</label>
                        <select id="acopio_id" class="form-select" wire:model="acopioSeleccionado">
                            <option value="">Seleccione...</option>
                            @foreach ($acopios as $acopio)
                                <option value="{{ $acopio->id }}">{{ $acopio->nombre }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="mb-3">
                        <label for="lineasSeleccionadas" class="form-label">Lineas</label>
                        <input type="text" id="lineasSeleccionadas" class="form-control" wire:model="lineasSeleccionadas">
                        </div>
                        <div class="mb-3">
                        <label for="cantidadSeleccionada" class="form-label">Cantidad</label>
                        <input type="number" id="cantidadSeleccionada" class="form-control" wire:model="cantidadSeleccionada">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" wire:click="agregarDetalle" data-bs-dismiss="modal">
                        Añadir
                        </button>
                    </div>
                    </div>
                </div>
                </div>
</div>

                            <a href="{{ route('cuadrillas.index') }}" class="btn btn-warning">
                                <i class="bi bi-arrow-left-short"></i> Volver
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Guardar
                            </button>
                        </form>

</div>