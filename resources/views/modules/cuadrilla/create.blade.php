<x-layouts::app :title="$cuadrilla ? __('Editar Cuadrilla') : __('Crear Cuadrilla')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos de la cuadrilla </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos de la cuadrilla.</p>

            </div>
            <form method="POST"
                action="{{ isset($cuadrilla) && $cuadrilla
                    ? route('cuadrillas.update', ['current_team' => request()->route('current_team'),'cuadrilla' => $cuadrilla->id,])
                    : route('cuadrillas.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($cuadrilla) && $cuadrilla)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">
                        <x-input-tex-agr name="fecha" label="Fecha" wire:model="fecha"
                        placeholder="Ej. Fecha de la cuadrilla"
                        :value="old('fecha', $cuadrilla?->fecha)" onchange="Livewire.dispatch('fechaActualizada', { fecha: this.value })"
                        required
                        autofocus type="date"/>

                        <x-input-tex-agr
                        name="nombre"
                        label="Nombre"
                        placeholder="Ej. Nombre de la cuadrilla"
                        :value="old('nombre', $cuadrilla?->nombre)"
                        required
                        autofocus/>
                        
                        <x-input-tex-agr
                        name="observacion"
                        label="Observación"
                        placeholder="Ej. Detalles sobre la cuadrilla"
                        :value="old('observacion', $cuadrilla?->observacion)"
                        required
                        autofocus/>
                        <div>
                            <label
                                for="labore_id"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Labor asociada
                            </label>

                            <select
                                id="labore_id"
                                name="labore_id"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100
                                       dark:focus:border-violet-500">
                                <option value="">
                                    Selecciona una labor
                                </option>

                                @foreach($labores as $labor)
                                    <option
                                        value="{{ $labor->id }}"
                                        @selected(old('labore_id', $cuadrilla?->labore_id) == $labor->id)>
                                        {{ $labor->actividad }}-{{ $labor->descripcion }}
                                    </option>
                                @endforeach
                            </select>

                            @error('labor_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        @livewire('create-cuadrilla', [
                                    'fechaInicial' => old('fecha', $cuadrilla->fecha ?? ''),
                                    'trabajadoresIniciales' => old(
                                    'trabajadores',
                                    $cuadrilla ? $cuadrilla->trabajadores->map(fn($t) => [
                                        'id' => $t->id,
                                        'nombres' => $t->nombres,
                                        'apellidos' => $t->apellidos,
                                        'fecha' => $t->pivot->fecha, // si quieres mostrar la fecha del pivot
                                    ])->toArray() : [])])
                    </div>

                </div>


                {{-- Acciones --}}
                <div
                    class="flex items-center justify-end gap-3 border-t border-neutral-200
                           px-6 py-4 dark:border-neutral-700">

                    <a
                        href="{{ route('cuadrillas.index') }}"
                        class="inline-flex items-center rounded-lg border border-neutral-300
                               px-4 py-2.5 text-sm font-medium text-neutral-700
                               transition hover:bg-neutral-100
                               focus:outline-none focus:ring-2 focus:ring-violet-500/20
                               dark:border-neutral-700 dark:text-neutral-300
                               dark:hover:bg-neutral-800">
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-violet-600
                               px-4 py-2.5 text-sm font-semibold text-white
                               transition hover:bg-violet-700
                               focus:outline-none focus:ring-2 focus:ring-violet-500/30">
                        {{ isset($cuadrilla) ? 'Actualizar Cuadrilla' : 'Crear Cuadrilla' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>