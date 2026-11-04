<?php

use Livewire\Component;
use App\Models\ReportesDiario;
use App\Models\DetReportesDiario;
use App\Models\Cuadrilla;
use Illuminate\Support\Facades\DB;
use App\Models\Labore;
use App\Models\Invfruta;
use Flux\Flux;

new class extends Component
{
    public $observacion, $reporte, $labores, $lotes, $acopios,$fecha;
    public $loteSeleccionado, $acopioSeleccionado, $lineasSeleccionadas, $cantidadSeleccionada, $laborSeleccionada, $cuadrillaSeleccionada;
    public $isEdit = false;
    public $laborNombre;
    public $detalles = [];
    public $cuadrillas = [];


    protected $listeners = ['fechaActualizada'];

   public function mount($reporte = null, $labores, $lotes, $acopios, $cuadrillas = [])
    {
        $this->labores = $labores;
        $this->lotes = $lotes;
        $this->acopios = $acopios;
        $this->cuadrillas = $cuadrillas;

        if ($reporte) {
            $this->isEdit = true;
            $this->reporte = $reporte;

            $this->fecha = $reporte->fecha;
            $this->cuadrillaSeleccionada = $reporte->cuadrilla_id;
            $this->laborSeleccionada = $reporte->labore_id;
            $this->observacion = $reporte->observacion;

            $this->detalles = $reporte->detalles->map(fn($d) => [
                'lote_id' => $d->lote_id,
                'acopio_id' => $d->acopios_id,
                'linea' => $d->lineas,
                'cantidad' => $d->cantidad,
            ])->toArray();


            // 👇 Forzar que la cuadrilla asignada esté en la lista
           if (!collect($this->cuadrillas)->contains('id', $this->cuadrillaSeleccionada)) {
                $this->cuadrillas[] = Cuadrilla::with(['labor','trabajadores'])->find($this->cuadrillaSeleccionada);
            }

            if ($reporte->cuadrilla->labor) {
                $this->laborNombre = $reporte->cuadrilla->labor->actividad;
            }
                    }
    }

    public function fechaActualizada($fecha)
    {
        $this->fecha = $fecha;

        // IDs de cuadrillas ya reportadas en esa fecha
        $cuadrillasReportadas = ReportesDiario::whereDate('fecha', $this->fecha)
            ->pluck('cuadrilla_id')
            ->toArray();

        // Si es edición, quitamos la cuadrilla actual de la lista de excluidos
        if ($this->isEdit && $this->cuadrillaSeleccionada) {
            $cuadrillasReportadas = array_diff($cuadrillasReportadas, [$this->cuadrillaSeleccionada]);
        }

        // Traer cuadrillas creadas en esa fecha que NO estén reportadas
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
        Flux::modal('modal-registro')->close();
    }

    public function eliminarDetalle($index)
    {
        unset($this->detalles[$index]);
        $this->detalles = array_values($this->detalles); // Reindexar el array
    }

    protected $rules = [
        'fecha' => 'required|date',
        'cuadrillaSeleccionada' => 'required|exists:cuadrillas,id',
        'laborSeleccionada' => 'required|exists:labores,id',
        'reporte.observacion' => 'nullable|string|max:255',

        // Validaciones para los detalles
        'detalles.*.lote_id' => 'required|exists:lotes,id',
        'detalles.*.acopio_id' => 'nullable|exists:acopios,id',
        'detalles.*.linea' => 'nullable|string|max:255',
        'detalles.*.cantidad' => 'required|numeric|min:1',
    ];

    public function save()
{
    $this->validate();
    $labor = Labore::find($this->laborSeleccionada);

    if ($this->isEdit) {
        // Actualizar el reporte existente
        $this->reporte->update([
            'fecha' => $this->fecha,
            'cuadrilla_id' => $this->cuadrillaSeleccionada,
            'labore_id' => $this->laborSeleccionada,
            'observacion' => $this->reporte->observacion ?? null,
        ]);

        // Eliminar detalles anteriores y volver a guardar
        $this->reporte->detalles()->delete();

        // 👇 Eliminar invfrutas anteriores asociados a este reporte
        Invfruta::where('reporte_id', $this->reporte->id)->delete();

        foreach ($this->detalles as $detalle) {
            $this->reporte->detalles()->create([
                'acopios_id' => $detalle['acopio_id'] ?? null,
                'lote_id' => $detalle['lote_id'],
                'lineas' => $detalle['linea'] ?? null,
                'cantidad' => $detalle['cantidad'],
            ]);
            if ($labor && $labor->invfruta) {
                $this->reporte->invfrutas()->create([
                    'fecha' => $this->fecha,
                    'lote_id' => $detalle['lote_id'],
                    'acopio_id' => $detalle['acopio_id'] ?? null,
                    'cantidad' => $detalle['cantidad'],
                    'cargado' => false,
                ]);
            }
        }
    } else {
        // Crear nuevo reporte
        $reporte = ReportesDiario::create([
            'fecha' => $this->fecha,
            'cuadrilla_id' => $this->cuadrillaSeleccionada,
            'labore_id' => $this->laborSeleccionada,
            'observacion' => $this->reporte['observacion'] ?? null,
        ]);

        foreach ($this->detalles as $detalle) {
            $reporte->detalles()->create([
                'acopios_id' => $detalle['acopio_id'] ?? null,
                'lote_id' => $detalle['lote_id'],
                'lineas' => $detalle['linea'] ?? null,
                'cantidad' => $detalle['cantidad'],
            ]);
            if ($labor && $labor->invfruta) {
                $reporte->invfrutas()->create([
                    'fecha' => $this->fecha,
                    'lote_id' => $detalle['lote_id'],
                    'acopio_id' => $detalle['acopio_id'] ?? null,
                    'cantidad' => $detalle['cantidad'],
                    'cargado' => false,
                ]);
            }
        }
    }

    return redirect()->route('reportes-diarios.index')->with('success', $this->isEdit ? 'Reporte actualizado exitosamente.' : 'Reporte creado exitosamente.');
}
    
};
?>

<div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

    <form wire:submit.prevent="save">
        @csrf

        @if (isset($reporte) && $reporte)
            @method('PUT')
        @endif

        {{-- Información general --}}
        <div class="mb-6">
            <flux:heading size="lg">Información del reporte</flux:heading>
            <flux:text size="sm" class="mt-1">
                Registra la información general de la jornada de trabajo.
            </flux:text>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

            {{-- Fecha --}}
            <flux:field>
                <flux:label for="fecha">Fecha</flux:label>

                <flux:input
                    type="date"
                    id="fecha"
                    name="fecha"
                    wire:model="fecha"
                    value="{{ old('fecha', $reporte->fecha ?? '') }}"
                    onchange="Livewire.dispatch('fechaActualizada', { fecha: this.value })"
                />

                <flux:error name="fecha" />
            </flux:field>

            {{-- Cuadrilla --}}
            <flux:field>
                <flux:label for="cuadrilla_id">Cuadrilla</flux:label>

                <flux:select
                    id="cuadrilla_id"
                    name="cuadrilla_id"
                    wire:model.live="cuadrillaSeleccionada"
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
                </flux:select>

                <flux:error name="cuadrilla_id" />
            </flux:field>

            {{-- Labor --}}
            <flux:field>
                <flux:label for="labor_nombre">Labor</flux:label>

                <flux:input
                    type="text"
                    id="labor_nombre"
                    wire:model="laborNombre"
                    readonly
                />

                {{-- Campo oculto para enviar el ID real --}}
                <input type="hidden" name="labore_id" value="{{ $laborSeleccionada }}">

                <flux:error name="labore_id" />
            </flux:field>

        </div>

        {{-- Observación --}}
        <div class="mt-5">
            <flux:field>
                <flux:label for="observacion">Observación</flux:label>

                <flux:textarea
                    id="observacion"
                    name="observacion"
                    rows="3"
                >{{ old('observacion', $reporte->observacion ?? '') }}</flux:textarea>

                <flux:error name="observacion" />
            </flux:field>
        </div>

        {{-- Detalle del registro diario --}}
        <div class="mt-8 overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">

            {{-- Encabezado de la tabla --}}
            <div class="flex flex-col gap-3 border-b border-zinc-200 bg-zinc-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700 dark:bg-zinc-800/60">

                <div>
                    <flux:heading size="lg">
                        Detalle del registro diario
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Administra los lotes, acopios y cantidades registrados.
                    </flux:text>
                </div>

                <flux:button
                    type="button"
                    variant="primary"
                    class="btn-create"
                    icon="plus"
                    x-on:click="$flux.modal('modal-registro').show()"
                >
                    Añadir registro
                </flux:button>

            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">

                    <thead class="bg-zinc-50 dark:bg-zinc-800/40">
                        <tr>
                            <th class="w-16 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                #
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Lote
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Acopio
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Líneas
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Cantidad
                            </th>

                            <th class="w-28 px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">

                        @forelse ($detalles as $detalle)

                            <tr
                                wire:key="detalle-{{ $loop->index }}"
                                class="transition-colors hover:bg-violet-50/50 dark:hover:bg-zinc-800/50"
                            >

                                <td class="px-5 py-3.5 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-3.5 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $lotes->find($detalle['lote_id'])->nombre ?? 'N/A' }}
                                </td>

                                <td class="px-5 py-3.5 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $acopios->find($detalle['acopio_id'])->nombre ?? 'N/A' }}
                                </td>

                                <td class="px-5 py-3.5 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $detalle['linea'] }}
                                </td>

                                <td class="px-5 py-3.5 text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                                    {{ $detalle['cantidad'] }}
                                </td>

                                <td class="px-5 py-3.5 text-center">
                                    <flux:button
                                        type="button"
                                        variant="ghost"
                                        color="danger"
                                        size="sm"
                                        icon="trash"
                                        title="Eliminar detalle"
                                        wire:click="eliminarDetalle({{ $loop->index }})"
                                    />
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center">

                                    <div class="flex flex-col items-center gap-2">

                                        <div class="flex size-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">
                                            <flux:icon.document-arrow-up class="size-6 text-zinc-400" />
                                        </div>

                                        <flux:heading size="sm">
                                            No hay detalles registrados
                                        </flux:heading>

                                        <flux:text size="sm">
                                            Añade un registro para comenzar.
                                        </flux:text>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

        {{-- Modal para añadir registro --}}
        <flux:modal name="modal-registro" class="md:w-120">

            <div class="space-y-6">

                <div>
                    <flux:heading size="lg">
                        Añadir registro
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Introduce los datos del detalle diario.
                    </flux:text>
                </div>

                {{-- Lote --}}
                <flux:field>
                    <flux:label for="lote_id">Lote</flux:label>

                    <flux:select
                        id="lote_id"
                        wire:model="loteSeleccionado"
                    >
                        <option value="">Seleccione...</option>

                        @foreach ($lotes as $lote)
                            <option value="{{ $lote->id }}">
                                {{ $lote->nombre }}
                            </option>
                        @endforeach

                    </flux:select>
                </flux:field>

                {{-- Acopio --}}
                <flux:field>
                    <flux:label for="acopio_id">Acopio</flux:label>

                    <flux:select
                        id="acopio_id"
                        wire:model="acopioSeleccionado"
                    >
                        <option value="">Seleccione...</option>

                        @foreach ($acopios as $acopio)
                            <option value="{{ $acopio->id }}">
                                {{ $acopio->nombre }}
                            </option>
                        @endforeach

                    </flux:select>
                </flux:field>

                {{-- Líneas --}}
                <flux:field>
                    <flux:label for="lineasSeleccionadas">Líneas</flux:label>

                    <flux:input
                        type="text"
                        id="lineasSeleccionadas"
                        wire:model="lineasSeleccionadas"
                    />
                </flux:field>

                {{-- Cantidad --}}
                <flux:field>
                    <flux:label for="cantidadSeleccionada">Cantidad</flux:label>

                    <flux:input
                        type="number"
                        id="cantidadSeleccionada"
                        wire:model="cantidadSeleccionada"
                    />
                </flux:field>

                {{-- Acciones --}}
                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                    <flux:modal.close>
                        <flux:button variant="ghost">
                            Cancelar
                        </flux:button>
                    </flux:modal.close>

                    <flux:button
                        type="button"
                        variant="primary"
                        class="btn-create"
                        icon="plus"
                        wire:click="agregarDetalle"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="agregarDetalle">
                            Añadir
                        </span>

                        <span wire:loading wire:target="agregarDetalle">
                            Añadiendo...
                        </span>
                    </flux:button>

                </div>

            </div>

        </flux:modal>

        {{-- Botones del formulario --}}
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end dark:border-zinc-700">

            <flux:button
                href="{{ route('reportes-diarios.index') }}"
                variant="ghost"
                icon="arrow-left"
            >
                Volver
            </flux:button>

            <flux:button
                type="submit"
                variant="primary"
                class="btn-create"
                icon="plus"
                wire:loading.attr="disabled"
                wire:target="save"
            >
                <span wire:loading.remove wire:target="save">
                    Guardar
                </span>

                <span wire:loading wire:target="save">
                    Guardando...
                </span>
            </flux:button>

        </div>

    </form>

</div>