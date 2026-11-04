<x-layouts::app :title="$labore ? __('Editar Labor') : __('Crear Labor')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos de la labor </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos de la labor.</p>

            </div>
            <form method="POST"
                action="{{ isset($labore) && $labore
                    ? route('labores.update', ['current_team' => request()->route('current_team'),'labore' => $labore->id,])
                    : route('labores.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($labore) && $labore)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">
                        <x-input-tex-agr name="actividad" label="Actividad" placeholder="Ej. Nombre de la actividad"
                        :value="old('actividad', $labore?->actividad)" required autofocus/>

                        <div>
                            <label
                                for="unidad_medida_id"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Unidad de Medida
                            </label>

                            <select
                                id="unidad_medida_id"
                                name="unidad_medida_id"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100
                                       dark:focus:border-violet-500"
                            >
                                <option value="">
                                    Seleccione una unidad de medida
                                </option>

                                @foreach($unidadesm as $unidad)
                                    <option
                                        value="{{ $unidad->id }}"
                                        @selected(old('unidad_medida_id', $labore?->unidad_medida_id) == $unidad->id)
                                    >
                                        {{ $unidad->nombre }}-{{ $unidad->abrev }}
                                    </option>
                                @endforeach
                            </select>

                            @error('unidad_medida_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <x-input-tex-agr name="rendimiento_esperado" label="Rendimiento Esperado" placeholder="Ej. Rendimiento esperado" type="number" step="0.01"
                        :value="old('rendimiento_esperado', $labore?->rendimiento_esperado)" required autofocus/>

                        <x-input-tex-agr name="valor_unitario" label="Valor Unitario" placeholder="Ej. 100.00" type="number" step="0.01"
                        :value="old('valor_unitario', $labore?->valor_unitario)" required autofocus/>

                        <x-input-tex-agr name="tarifa_contratista" label="Tarifa Contratista" placeholder="Ej. 100.00" type="number" step="0.01"
                        :value="old('tarifa_contratista', $labore?->tarifa_contratista)" autofocus/>

                        <x-input-tex-agr name="tarifa_personal_directo" label="Tarifa Personal Directo" placeholder="Ej. 100.00" type="number" step="0.01"
                        :value="old('tarifa_personal_directo', $labore?->tarifa_personal_directo)" autofocus/>

                        <x-input-tex-agr name="valor_prestaciones" label="Valor Prestaciones" placeholder="Ej. 100.00" type="number" step="0.01"
                        :value="old('valor_prestaciones', $labore?->valor_prestaciones)" autofocus/>

                        <x-input-tex-agr name="valor_total" label="Valor Total" placeholder="Ej. 100.00" type="number" step="0.01"
                        :value="old('valor_total', $labore?->valor_total)" autofocus/>

                        <x-input-tex-agr name="observaciones" label="Observaciones" placeholder="Ej. Observaciones"
                        :value="old('observaciones', $labore?->observaciones)" autofocus/>

                        <div>
                            <input type="hidden" name="invfruta" value="0">
                            <flux:field>
                                <flux:label>Genera inventario de fruta</flux:label>

                                <flux:switch
                                    name="invfruta"
                                    value="1"
                                    :checked="old('invfruta', $labore?->invfruta)"
                                />

                                <flux:error name="invfruta" />
                            </flux:field>

                            @error('invfruta')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                </div>


                {{-- Acciones --}}
                <div
                    class="flex items-center justify-end gap-3 border-t border-neutral-200
                           px-6 py-4 dark:border-neutral-700"
                >

                    <a
                        href="{{ route('labores.index') }}"
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
                        {{ isset($labore) ? 'Actualizar Labor' : 'Crear Labor' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>