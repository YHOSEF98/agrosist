<?php

use Livewire\Component;
use App\Models\Conductore;
use Illuminate\Support\Facades\Auth;
use App\Models\Invfruta;
use Flux\Flux;
use App\Models\RemisionFruto;
use App\Models\DetViajeFruto;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Models\Empresa;
use App\Models\Provedore;
use App\Models\Finca;

new class extends Component
{
    public $remision, $fecha, $teams, $destinos, $proveedores, $conductores=[], $placa='', $autorizado, $firma_conductor, $fincas, $empresa, $invfrutas =[];
    public $detalles = [], $conductorSeleccionado, $destinoSeleccionado, $proveedorSeleccionado, $fincaSeleccionada, $invfrutaSeleccionada, $frutaLevantada;
    public $acopioSeleccionado, $lineasSeleccionadas, $cantidadSeleccionada, $no_remision;

    public function updatedProvedoreId($value)
    {
        $this->conductores = Conductore::where('provedore_id', $value)->get();
    }

    public function numero_remision()
    {
        if ($this->remision) {

            $this->no_remision = $this->remision->remision;

        } else {

            $empresa = $this->empresa->empresa;

            if (!$empresa) {
                throw new \Exception('El equipo actual no tiene una empresa registrada.');
            }

            $this->no_remision = ($empresa->no_remision ?? 0) + 1;
        }
    }

    public function mount(?RemisionFruto $remision = null)
    {
        $this->remision = $remision;

        // Cargar información para los selectores
        $this->destinos = Provedore::where('es_cliente', true)->get();
        $this->proveedores = Provedore::all();
        $this->fincas = Finca::all();

        // Datos del Team actual
        $this->empresa = Auth::user()->currentTeam;
        $this->autorizado = Auth::user()->name;

        if ($this->remision && $this->remision->exists) {

            // =====================================
            // EDITAR REMISIÓN EXISTENTE
            // =====================================

            // Cargar encabezado
            $this->fecha = $this->remision->fecha;
            $this->no_remision = $this->remision->remision;
            $this->fincaSeleccionada = $this->remision->finca_id;
            $this->destinoSeleccionado = $this->remision->destino_id;
            $this->proveedorSeleccionado = $this->remision->provedore_id;
            $this->conductorSeleccionado = $this->remision->conductore_id;
            $this->placa = $this->remision->placa;
            $this->autorizado = $this->remision ? $this->remision->autorizado_por : Auth::user()->name;

            // Cargar conductores del proveedor seleccionado
            $this->conductores = Conductore::where(
                'provedore_id',
                $this->proveedorSeleccionado
            )->get();

            // Cargar detalles e inventarios relacionados
            $this->remision->load('detalles.invfruta.lote');

            $this->detalles = $this->remision->detalles->map(function ($detalle) {

                return [
                    'invfruta_id' => $detalle->invfrutas_id,
                    'lote_id' => $detalle->invfruta->lote->nombre,
                    'cantidad' => $detalle->invfruta->cantidad,
                    'cantidad_cargada' => $detalle->cantidad_cargada,
                ];

            })->toArray();

        } else {

            // =====================================
            // CREAR NUEVA REMISIÓN
            // =====================================

            $this->numero_remision();
        }

        // Cargar inventarios disponibles
        $this->cargarInvfrutas();
    }
    public function updateAutorizado($value)
    {
        $this->autorizado = $value;
    }

    protected function rules()
    {
        return [
            'fecha' => 'required|date',
            'fincaSeleccionada' => ['required',Rule::exists((new \App\Models\Finca)->getTable(), 'id'),],
            'destinoSeleccionado' => ['required',Rule::exists((new \App\Models\Provedore)->getTable(), 'id'),],
            'proveedorSeleccionado' => ['required', Rule::exists((new \App\Models\Provedore)->getTable(), 'id'),],
            'conductorSeleccionado' => ['required',Rule::exists((new \App\Models\Conductore)->getTable(), 'id'),],
            'placa' => 'required|string|max:20',
            'autorizado' => 'required|string|max:255',
            'detalles' => 'required|array|min:1',
            'detalles.*.invfruta_id' => 'required|exists:invfrutas,id',
            'detalles.*.cantidad_cargada' => 'required|integer|min:1',
        ];
    }

    public function updatedProveedorSeleccionado($proveedorId)
    {
        $this->conductorSeleccionado = null;
        $this->placa = null;
        $this->conductores = Conductore::where('provedore_id', $proveedorId)->get();
    }
    public function updatedConductorSeleccionado($conductorId)
    {
        if (!$conductorId) {
            $this->placa = null;
            return;
        }

        $this->placa = Conductore::where('id', $conductorId)
            ->value('placa');
    }
    public function cargarInvfrutas()
    {
         $this->invfrutas = Invfruta::where('cargado', false)
            ->with('lote')
            ->get()
            ->filter(function ($invfruta) {

                $cantidadCargada = collect($this->detalles)
                    ->where('invfruta_id', $invfruta->id)
                    ->sum('cantidad_cargada');

                $disponible = $invfruta->cantidad - $cantidadCargada;

                return $disponible > 0;
            })
            ->map(function ($invfruta) {

                $cantidadCargada = collect($this->detalles)
                    ->where('invfruta_id', $invfruta->id)
                    ->sum('cantidad_cargada');

                // Actualizar la cantidad disponible para mostrarla
                $invfruta->cantidad = $invfruta->cantidad - $cantidadCargada;

                return $invfruta;
            });
    }
    public function agregarDetalle(){
        $det_fruto = Invfruta::with('lote')
        ->findOrFail($this->invfrutaSeleccionada);

        // Sumar lo que ya se ha cargado de este inventario
        $cantidadAnterior = collect($this->detalles)
            ->where('invfruta_id', $det_fruto->id)
            ->sum('cantidad_cargada');

        // Calcular disponibilidad real
        $disponible = $det_fruto->cantidad - $cantidadAnterior;

        // Validar que no supere la cantidad disponible
        if ($this->frutaLevantada > $disponible || $this->frutaLevantada <= 0) {
            Flux::toast(
                text: 'La cantidad supera el inventario disponible.',
                variant: 'danger'
            );

            return;
        }

        $this->detalles[] = [
            'invfruta_id' => $det_fruto->id,
            'lote_id' => $det_fruto->lote->nombre,
            'cantidad' => $disponible,
            'cantidad_cargada' => $this->frutaLevantada,
        ];

        $this->reset('invfrutaSeleccionada', 'frutaLevantada');

        Flux::modal('modal-registro')->close();

        $this->cargarInvfrutas();
    }

    public function eliminarDetalle($invfrutaId)
    {
        foreach ($this->detalles as $index => $detalle) {

            if ($detalle['invfruta_id'] == $invfrutaId) {

                unset($this->detalles[$index]);
                break;
            }
        }

        $this->detalles = array_values($this->detalles);
        $this->cargarInvfrutas();
    }

    public function save()
    {
        // Validar los datos del formulario
        $this->validate();

        $esEdicion = $this->remision && $this->remision->exists;

        DB::transaction(function () use ($esEdicion) {

            /*
            |--------------------------------------------------------------------------
            | 1. Crear o recuperar la remisión
            |--------------------------------------------------------------------------
            */

            if ($esEdicion) {

                // Bloquear la remisión mientras se actualiza
                $remision = RemisionFruto::whereKey($this->remision->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Obtener los detalles que tenía anteriormente
                $detallesAnteriores = $remision->detalles()->get();

            } else {

                $detallesAnteriores = collect();

                // Bloquear la empresa para generar el consecutivo
                $empresa = $this->empresa
                    ->empresa()
                    ->lockForUpdate()
                    ->firstOrFail();

                // Generar el siguiente número de remisión
                $this->no_remision = ($empresa->no_remision ?? 0) + 1;

                // Crear la remisión
                $remision = RemisionFruto::create([
                    'team_id' => $this->empresa->id,
                    'remision' => $this->no_remision,
                    'fecha' => $this->fecha,
                    'finca_id' => $this->fincaSeleccionada,
                    'destino_id' => $this->destinoSeleccionado,
                    'provedore_id' => $this->proveedorSeleccionado,
                    'conductore_id' => $this->conductorSeleccionado,
                    'placa' => $this->placa,
                    'autorizado_por' => $this->autorizado,
                ]);

                // Actualizar consecutivo de la empresa
                $empresa->update([
                    'no_remision' => $this->no_remision,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Actualizar datos generales si estamos editando
            |--------------------------------------------------------------------------
            */

            if ($esEdicion) {

                $remision->update([
                    'fecha' => $this->fecha,
                    'finca_id' => $this->fincaSeleccionada,
                    'destino_id' => $this->destinoSeleccionado,
                    'provedore_id' => $this->proveedorSeleccionado,
                    'conductore_id' => $this->conductorSeleccionado,
                    'placa' => $this->placa,
                    'autorizado_por' => $this->autorizado,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | 3. Agrupar detalles anteriores y nuevos
            |--------------------------------------------------------------------------
            */

            // Cantidades que estaban registradas anteriormente
            $anterioresAgrupados = $detallesAnteriores->groupBy('invfrutas_id');

            // Nuevas cantidades ingresadas en el formulario
            $nuevosAgrupados = collect($this->detalles)->groupBy('invfruta_id');

            // Unir los IDs de inventario anteriores y nuevos
            $idsInventario = $anterioresAgrupados->keys()
                ->merge($nuevosAgrupados->keys())
                ->unique()
                ->sort()
                ->values();

            /*
            |--------------------------------------------------------------------------
            | 4. Bloquear los registros de inventario
            |--------------------------------------------------------------------------
            */

            $inventarios = Invfruta::whereIn('id', $idsInventario)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            /*
            |--------------------------------------------------------------------------
            | 5. Devolver las cantidades anteriores al inventario
            |--------------------------------------------------------------------------
            */

            foreach ($anterioresAgrupados as $invfrutaId => $detalles) {

                $invfruta = $inventarios->get($invfrutaId);

                if (!$invfruta) {
                    throw new \Exception(
                        "No se encontró el inventario con ID {$invfrutaId}."
                    );
                }

                // Sumar todas las cantidades que pertenecían a esta remisión
                $cantidadAnterior = $detalles->sum('cantidad_cargada');

                // Devolverlas al inventario
                $invfruta->cantidad_cargada -= $cantidadAnterior;

                if ($invfruta->cantidad_cargada < 0) {
                    throw new \Exception(
                        "El inventario del lote {$invfruta->lote->nombre} presenta cantidades inconsistentes."
                    );
                }

                // Recalcular el estado del inventario
                $invfruta->cargado =
                    $invfruta->cantidad_cargada >= $invfruta->cantidad;

                $invfruta->save();
            }

            /*
            |--------------------------------------------------------------------------
            | 6. Eliminar los detalles anteriores
            |--------------------------------------------------------------------------
            */

            if ($esEdicion) {
                $remision->detalles()->delete();
            }

            /*
            |--------------------------------------------------------------------------
            | 7. Registrar los nuevos detalles y descontar inventario
            |--------------------------------------------------------------------------
            */

            foreach ($nuevosAgrupados as $invfrutaId => $detalles) {

                $invfruta = $inventarios->get($invfrutaId);

                if (!$invfruta) {
                    throw new \Exception(
                        "No se encontró el inventario con ID {$invfrutaId}."
                    );
                }

                // Sumar las cantidades solicitadas para este inventario
                $cantidadSolicitada = $detalles->sum('cantidad_cargada');

                // Calcular saldo disponible
                $disponible = $invfruta->cantidad - $invfruta->cantidad_cargada;

                // Comprobar que exista suficiente fruta
                if ($cantidadSolicitada > $disponible) {

                    throw ValidationException::withMessages([
                        'detalles' => "El inventario del lote {$invfruta->lote->nombre} no tiene suficiente cantidad disponible. Saldo: {$disponible} kg."
                    ]);
                }

                // Crear nuevamente cada detalle
                foreach ($detalles as $detalle) {

                    DetViajeFruto::create([
                        'remision_fruto_id' => $remision->id,
                        'invfrutas_id' => $invfruta->id,
                        'cantidad_cargada' => $detalle['cantidad_cargada'],
                    ]);
                }

                // Descontar del inventario las nuevas cantidades
                $invfruta->cantidad_cargada += $cantidadSolicitada;

                // Recalcular si todo el inventario quedó cargado
                $invfruta->cargado =
                    $invfruta->cantidad_cargada >= $invfruta->cantidad;

                $invfruta->save();
            }
        });

        /*
        |--------------------------------------------------------------------------
        | 8. Confirmar operación
        |--------------------------------------------------------------------------
        */

        session()->flash(
            'success',
            $esEdicion
                ? 'Remisión actualizada correctamente.'
                : 'Remisión registrada correctamente.'
        );

        return redirect()->route('alce-fruto.index');
    }
};
?>

<div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

    <form wire:submit.prevent="save">
        @csrf

        @if (isset($remision) && $remision)
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
                    value="{{ old('fecha', $remision->fecha ?? '') }}"
                />

                <flux:error name="fecha" />
            </flux:field>
            <flux:field>
                <flux:label for="no_remision">N° Remision</flux:label>

                <flux:input
                    type="text"
                    id="no_remision"
                    name="no_remision"
                    wire:model="no_remision"
                    value="{{ old('no_remision', $remision->remision ?? '') }}"
                    readonly
                />

                <flux:error name="no_remision" />
            </flux:field>

            {{-- Finca --}}
            <flux:field>
                <flux:label for="finca_id">Finca</flux:label>

                <flux:select
                    id="finca_id"
                    name="finca_id"
                    wire:model.live="fincaSeleccionada"
                >
                    <option value="">Seleccione...</option>

                    @foreach ($fincas as $finca)
                        <option value="{{ $finca->id }}">
                            {{ $finca->nombre }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:error name="fincaSeleccionada" />
            </flux:field>

            {{-- Destino --}}
           <flux:field>
                <flux:label for="destino_id">Destino</flux:label>

                <flux:select
                    id="destino_id"
                    name="destino_id"
                    wire:model.live="destinoSeleccionado"
                >
                    <option value="">Seleccione...</option>

                    @foreach ($destinos as $destino)
                        <option value="{{ $destino->id }}">
                            {{ $destino->razon_social }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:error name="destinoSeleccionado" />
            </flux:field>

            {{-- Proveedor --}}

            <flux:field>
                <flux:label for="proveedorSeleccionado">Proveedor</flux:label>

                <flux:select
                    id="proveedorSeleccionado"
                    name="proveedorSeleccionado"
                    wire:model.live="proveedorSeleccionado"
                >
                    <option value="">Seleccione...</option>

                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">
                            {{ $proveedor->razon_social }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:error name="proveedorSeleccionado" />
            </flux:field>

         <flux:field>
                <flux:label for="conductorSeleccionado">Conductor</flux:label>

                <flux:select
                    id="conductorSeleccionado"
                    name="conductorSeleccionado"
                    wire:model.live="conductorSeleccionado"
                >
                    <option value="">Seleccione...</option>

                    @foreach ($conductores as $conductor)
                        <option value="{{ $conductor->id }}">
                            {{ $conductor->nombres }} {{ $conductor->apellidos }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:error name="conductorSeleccionado" />
            </flux:field>

             <flux:field>
                <flux:label for="placa">Placa</flux:label>

                <flux:input
                    type="text"
                    id="placa"
                    wire:model="placa"
                    readonly
                />

                {{-- Campo oculto para enviar el ID real --}}
                <input type="hidden" name="placa" value="{{ $placa }}">

                <flux:error name="placa" />
        </flux:field>
        <flux:field>
                <flux:label for="autorizado">Autorizado por</flux:label>

                <flux:input
                    type="text"
                    id="autorizado"
                    wire:model="autorizado"
                    readonly
                />

                <flux:error name="autorizado" />
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

                <flux:button
                    type="button"
                    variant="primary"
                    class="btn-create"
                    icon="plus"
                    x-on:click="$flux.modal('modal-registro').show()"
                >
                    Añadir fruto
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
                                Cantidad disponible
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Cantidad cargada
                            </th>

                            <th class="w-28 px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">

                        @forelse ($detalles as $detalle)

                            <tr
                                wire:key="detalle-{{ $detalle['invfruta_id'] }}"
                                class="transition-colors hover:bg-violet-50/50 dark:hover:bg-zinc-800/50"
                            >

                                <td class="px-5 py-3.5 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-3.5 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $detalle['lote_id'] }}
                                </td>

                                <td class="px-5 py-3.5 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $detalle['cantidad'] }}
                                </td>

                                <td class="px-5 py-3.5 text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                                    {{ $detalle['cantidad_cargada'] }}
                                </td>

                                <td class="px-5 py-3.5 text-center">
                                    <flux:button
                                        type="button"
                                        variant="ghost"
                                        color="danger"
                                        size="sm"
                                        icon="trash"
                                        title="Eliminar detalle"
                                        wire:click="eliminarDetalle({{ $detalle['invfruta_id'] }})"
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

        {{-- Modal para añadir registro --}}
        <flux:modal name="modal-registro" class="md:w-120">

            <div class="space-y-6">

                <div>
                    <flux:heading size="lg">
                        Añadir fruta
                    </flux:heading>

                    <flux:text size="sm" class="mt-1">
                        Seleccione los acopios a recoger.
                    </flux:text>
                </div>
 
                
                <flux:field>
                    <flux:label for="invfruta_id">Fruta para cargar</flux:label>

                    <flux:select
                        id="invfruta_id"
                        wire:model.live="invfrutaSeleccionada"
                    >
                        <option value="">Seleccione...</option>

                        @foreach ($invfrutas as $invfruta)
                            <option value="{{ $invfruta->id }}">
                                Cosechado el: {{ $invfruta->fecha }} -  {{ $invfruta->lote->nombre }} - Cantidad: {{ $invfruta->cantidad }}
                            </option>
                        @endforeach

                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:label for="frutaLevantada">Cantidad cargada</flux:label>

                    <flux:input
                        type="number"
                        id="frutaLevantada"
                        wire:model="frutaLevantada"
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