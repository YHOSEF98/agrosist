<x-layouts::app :title="$pluviometria ? __('Editar Pluviometría') : __('Crear Pluviometría')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos del Pluviómetro </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos del pluviómetro.</p>

            </div>
            <form method="POST"
                action="{{ isset($pluviometria) && $pluviometria
                    ? route('pluviometria.update', ['current_team' => request()->route('current_team'),'pluviometria' => $pluviometria->id,])
                    : route('pluviometria.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($pluviometria) && $pluviometria)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">
                        <x-input-tex-agr
                        name="fecha"
                        type="date"
                        label="Fecha"
                        placeholder="Ej. Fecha del pluviometría"
                        :value="old('fecha', $pluviometria?->fecha)"
                        required
                        autofocus/>

                         <div>
                            <label
                                for="pluviometro_id"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Pluviómetro
                            </label>

                            <select
                                id="pluviometro_id"
                                name="pluviometro_id"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100
                                       dark:focus:border-violet-500"
                            >
                                <option value="">
                                    Seleccione un pluviómetro
                                </option>

                                @foreach($pluviometros as $pluviometro)
                                    <option
                                        value="{{ $pluviometro->id }}"
                                        @selected(old('pluviometro_id', $pluviometria?->pluviometro_id) == $pluviometro->id)
                                    >
                                        {{ $pluviometro->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @error('pluviometro_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <x-input-tex-agr
                        name="cantidad"
                        type="number"
                        label="Cantidad"
                        placeholder="Ej. 100"
                        :value="old('cantidad', $pluviometria?->cantidad)"
                        required
                        autofocus/>

                    </div>

                </div>


                {{-- Acciones --}}
                <div
                    class="flex items-center justify-end gap-3 border-t border-neutral-200
                           px-6 py-4 dark:border-neutral-700">

                    <a
                        href="{{ route('pluviometria.index') }}"
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
                        {{ isset($pluviometria) ? 'Actualizar Pluviometría' : 'Crear Pluviometría' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>