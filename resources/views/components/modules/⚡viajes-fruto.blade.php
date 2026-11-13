<?php

use Livewire\Component;
use App\Models\RemisionFruto;
use App\Models\DetViajeFruto;
use App\Models\ViajeFruto;
use App\Models\DetalleViaje;
use Illuminate\Support\Facades\DB;
use Flux\Flux;

new class extends Component
{
    public $detalles=[], $remisiones,$fecha, $ticket, $ticket_c, $peso_bruto,$tara,$peso_neto_viaje=0, $calidad, $peso_final;
    public $remisionSeleccionada, $subtotal_detalles=0, $peso_restante;
    public ?ViajeFruto $viaje = null;

    protected function rules(){
        return [
            'fecha'=> 'required|date',
            'ticket'=> 'required|integer|min:0',
            'ticket_c'=> 'required|integer|min:0',
            'remisionSeleccionada'=> 'required|exists:remision_frutos,id',
            'peso_bruto'=> 'required|integer|min:0',
            'tara'=> 'required|integer|min:0',
            'peso_neto_viaje'=> 'required|integer|min:0',
            'calidad'=> 'required|integer|min:0',

            'detalles' => 'required|array|min:1',
            'detalles.*.id' => 'required|exists:det_viaje_frutos,id',
            'detalles.*.promedio' => 'required|numeric|min:0',
            'detalles.*.peso_neto' => 'required|numeric|min:0',
            ];
    }

    public function mount(?ViajeFruto $viaje = null)
    {
        $this->viaje = $viaje;

        if ($this->viaje && $this->viaje->exists) {

            $this->viaje->load([
                'remisionfruto',
                'detalles.det_remision.invfruta.lote',
            ]);

            $this->fecha = $this->viaje->fecha;
            $this->remisionSeleccionada = $this->viaje->remision_fruto_id;

            // Solo mostrar la remisión actual
            $this->remisiones = collect([
                $this->viaje->remisionfruto
            ]);

            $this->ticket = $this->viaje->ticket;
            $this->ticket_c = $this->viaje->ticket_c;
            $this->peso_bruto = $this->viaje->peso_bruto;
            $this->tara = $this->viaje->tara;
            $this->calidad = $this->viaje->ajuste_calidad;

            $this->detalles = [];

            foreach ($this->viaje->detalles as $detalle) {

                $this->detalles[] = [
                    'id' => $detalle->det_viaje_fruto_id,

                    'lote' => $detalle->det_remision->invfruta->lote->nombre,

                    'cantidad_cargada' => $detalle->det_remision->cantidad_cargada,

                    'promedio' => $detalle->promedio,

                    'peso_neto' => $detalle->peso_neto,
                ];
            }
            $this->calcularPesoNetoViaje();

        } else {

            $this->remisiones = RemisionFruto::whereDoesntHave('viajeFruto')
                ->get();
        }
    }

    public function updatedRemisionSeleccionada($id)
    {
        $remision = RemisionFruto::with('detalles.invfruta.lote')
            ->find($id);

        $this->detalles = $remision?->detalles->map(function ($detalle) {
            return [
                'id' => $detalle->id,
                'lote' => $detalle->invfruta->lote->nombre,
                'cantidad_cargada' => $detalle->cantidad_cargada,
                'promedio' => 0,
                'peso_neto' => 0,
            ];
        })->toArray() ?? [];
    }
    public function updatedPesoBruto()
    {
        $this->calcularPesoNetoViaje();
    }

    public function updatedTara()
    {
        $this->calcularPesoNetoViaje();
    }

    private function calcularPesoNetoViaje()
    {
        $bruto = is_numeric($this->peso_bruto)
            ? (float) $this->peso_bruto
            : 0;

        $tara = is_numeric($this->tara)
            ? (float) $this->tara
            : 0;

        $this->peso_neto_viaje = $bruto - $tara;
        $this->recalcularPesos();

    }

    public function getPesoFinalProperty()
    {
        return (float) $this->peso_neto_viaje - (float) $this->calidad;
    }

    public function recalcularPesos()
    {
        $this->subtotal_detalles = collect($this->detalles)
            ->sum(function ($detalle) {
                return is_numeric($detalle['peso_neto'] ?? null)
                    ? (float) $detalle['peso_neto']
                    : 0;
            });

        $this->peso_restante = round(
            $this->peso_neto_viaje - $this->subtotal_detalles,
            2
        );
    }

    public function updatedDetalles($value, $key)
    {
        $partes = explode('.', $key);

        if (count($partes) < 2) {
            return;
        }

        $index = (int) $partes[0];
        $campo = $partes[1];

        $cantidad = (float) ($this->detalles[$index]['cantidad_cargada'] ?? 0);

        if ($campo === 'promedio') {

            $promedio = is_numeric($value)
                ? (float) $value
                : 0;

            $this->detalles[$index]['peso_neto'] = round(
                $cantidad * $promedio,
                2
            );
        }

        if ($campo === 'peso_neto') {

            $peso = is_numeric($value)
                ? (float) $value
                : 0;

            $this->detalles[$index]['promedio'] = $cantidad > 0
                ? round($peso / $cantidad, 2)
                : 0;
        }

        $this->recalcularPesos();
    }

    public function save()
    {
        $this->validate();

        if ((float) $this->peso_restante != 0) {

            Flux::toast(
                heading: 'Peso pendiente',
                text: 'El peso neto aún no ha sido distribuido completamente entre los detalles del viaje.',
                variant: 'warning'
            );

            return;
        }

        DB::transaction(function () {

            $viaje = $this->viaje ?? new ViajeFruto();

            $viaje->fill([
                'fecha'             => $this->fecha,
                'remision_fruto_id' => $this->remisionSeleccionada,
                'ticket'            => $this->ticket,
                'ticket_c'          => $this->ticket_c,
                'peso_bruto'        => $this->peso_bruto,
                'tara'              => $this->tara,
                'peso_neto'         => $this->peso_neto_viaje,
                'ajuste_calidad'    => $this->calidad,
                'peso_final'        => $this->pesoFinal,
            ]);

            $viaje->save();

            // Si estamos editando, reconstruimos los detalles
            $viaje->detalles()->delete();

            foreach ($this->detalles as $detalle) {

                DetalleViaje::create([
                    'viaje_fruto_id'     => $viaje->id,
                    'det_viaje_fruto_id' => $detalle['id'],
                    'promedio'           => $detalle['promedio'],
                    'peso_neto'          => $detalle['peso_neto'],
                ]);
            }
        });

        session()->flash(
            'success',
            $this->viaje
                ? 'Viaje actualizado correctamente.'
                : 'Viaje creado correctamente.'
        );

        return redirect()->route('viajes-fruto.index');
    }
    
};
?>

<div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
    
    <form wire:submit.prevent="save">
        @csrf

        @if (isset($viaje) && $viaje)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

            {{-- Fecha --}}
            <flux:field>
                <flux:label for="fecha">Fecha</flux:label>

                <flux:input
                    type="date"
                    id="fecha"
                    name="fecha"
                    wire:model="fecha"
                    value="{{ old('fecha', $viaje->fecha ?? '') }}"
                />

                <flux:error name="fecha" />
            </flux:field>

            @if ($viaje)

                <flux:field>
                    <flux:label for="remision">Remisión</flux:label>

                    <flux:input
                        type="text"
                        value="{{ $viaje->remisionfruto?->remision }}"
                        readonly
                    />

                    <flux:error name="remisionSeleccionada" />
                </flux:field>

            @else

                <flux:field>
                    <flux:label for="remision_id">Remisión</flux:label>

                    <flux:select
                        id="remision_id"
                        wire:model.live="remisionSeleccionada"
                    >
                        <option value="">Seleccione...</option>

                        @foreach ($remisiones as $remision)
                            <option value="{{ $remision->id }}">
                                {{ $remision->remision }}
                            </option>
                        @endforeach

                    </flux:select>

                    <flux:error name="remisionSeleccionada" />
                </flux:field>

            @endif

            <flux:field>
                <flux:label for="ticket"># Ticket</flux:label>

                <flux:input
                    type="text"
                    id="autorizado"
                    wire:model="ticket"
                />

                <flux:error name="ticket" />
            </flux:field>

            <flux:field>
                <flux:label for="ticket"># Ticket c</flux:label>

                <flux:input
                    type="text"
                    id="autorizado"
                    wire:model="ticket_c"
                />

                <flux:error name="ticket_c" />
            </flux:field>

            <flux:field>
                <flux:label for="peso_bruto">Peso bruto</flux:label>

                <flux:input
                    type="number"
                    id="peso_bruto"
                    wire:model.live="peso_bruto"
                />

                <flux:error name="peso_bruto" />
            </flux:field>

            <flux:field>
                <flux:label for="tara">Tara</flux:label>

                <flux:input
                    type="number"
                    id="tara"
                    wire:model.live="tara"
                />

                <flux:error name="tara" />
            </flux:field>

            <flux:field>
                <flux:label for="peso_neto_viaje">Peso Neto</flux:label>

                <flux:input
                    type="number"
                    id="peso_neto_viaje"
                    wire:model.live="peso_neto_viaje"
                    readonly
                />

                <flux:error name="peso_neto_viaje" />
            </flux:field>

             <flux:field>
                <flux:label for="calidad">Ajuste de calidad</flux:label>

                <flux:input
                    type="number"
                    id="calidad"
                    wire:model.live="calidad"
                />

                <flux:error name="calidad" />
            </flux:field>

            <flux:field>
                <flux:label for="peso_final">Peso liq final</flux:label>

                <flux:input
                    type="number"
                    id="peso_final"
                    :value="$this->pesoFinal"
                    readonly
                />

                <flux:error name="peso_final" />
            </flux:field>

        </div>

        {{-- Detalle del registro diario --}}
        <div class="mt-8 overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">

            {{-- Encabezado de la tabla --}}
            <div class="flex flex-col gap-3 border-b border-zinc-200 bg-zinc-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700 dark:bg-zinc-800/60">

                <div>
                    <flux:heading size="lg">
                        Detalle de la remision
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Administra el cargue con sus respectivas cantidades.
                    </flux:text>
                </div>

                <flux:field>
                <flux:label for="peso_restante">Peso por relacionar</flux:label>

                <flux:input
                    type="number"
                    id="peso_restante"
                    wire:model.live="peso_restante"
                    readonly
                />

                <flux:error name="peso_restante" />
                </flux:field>

                <flux:field>
                <flux:label for="subtotal_detalles">Subtotal</flux:label>

                <flux:input
                    type="number"
                    id="subtotal_detalles"
                    wire:model.live="subtotal_detalles"
                    readonly
                />
                <flux:error name="subtotal_detalles" />
                </flux:field>

                

            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700" auto>

                    <thead class="bg-zinc-50 dark:bg-zinc-800/40">
                        <tr>
                            <th class="w-16 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                #
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Lote
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Cantidad de racimos
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Promedio
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Peso neto
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">

                        @forelse ($detalles as $detalle)

                            <tr
                                wire:key="detalle-{{ $detalle['id'] }}"
                                class="transition-colors hover:bg-violet-50/50 dark:hover:bg-zinc-800/50"
                            >

                                <td class="px-5 py-3.5 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-3.5 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $detalle['lote'] }}
                                </td>

                                <td class="px-5 py-3.5 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $detalle['cantidad_cargada'] }}
                                </td>

                                <td class="px-5 py-3.5 text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                                    <flux:input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        wire:model.live="detalles.{{ $loop->index }}.promedio"
                                    />
                                </td>
                                 <td>
                                    <flux:input
                                        type="number"
                                        step="0.01"
                                        wire:model.live="detalles.{{ $loop->index }}.peso_neto"
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
                <flux:error name="detalles" />

            </div>
        </div>

        {{-- Botones del formulario --}}
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end dark:border-zinc-700">

            <flux:button
                href="{{ route('alce-fruto.index') }}"
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