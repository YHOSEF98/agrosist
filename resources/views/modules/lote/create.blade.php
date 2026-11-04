<x-layouts::app :title="$lote ? __('Editar Lote') : __('Crear Lote')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos del lote </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos del lote.</p>

            </div>
            <form method="POST"
                action="{{ isset($lote) && $lote
                    ? route('lotes.update', ['current_team' => request()->route('current_team'),'lote' => $lote->id,])
                    : route('lotes.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($lote) && $lote)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">


                        {{-- Equipo --}}
                        <div>
                            <label for="finca_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Finca al que pertenece </label>

                            <select
                                id="finca_id"
                                name="finca_id"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100
                                       dark:focus:border-violet-500">
                                <option value="">
                                    Seleccione una finca
                                </option>

                                @foreach($fincas as $finca)
                                    <option
                                        value="{{ $finca->id }}"
                                        @selected(old('finca_id', $lote?->finca_id) == $finca->id)
                                    >
                                        {{ $finca->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @error('finca_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Nombre
                             </label>

                            <input id="nombre" name="nombre" type="text" value="{{ old('nombre', $lote?->nombre) }}"
                                required autofocus autocomplete="finca" placeholder="Ej. finca la palma"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500">

                            @error('nombre')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label
                                for="ubicacion"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Ubicación
                            </label>

                            <input id="ubicacion" name="ubicacion" type="text" value="{{ old('ubicacion', $lote?->ubicacion) }}"
                                autocomplete="finca" placeholder="Ej. coordenadas de la finca"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('ubicacion')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                            
                        </div>
                        <div>
                            <label
                                for="cultivo"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Cultivo
                            </label>

                            <input id="cultivo" name="cultivo" type="text" value="{{ old('cultivo', $lote?->cultivo) }}"
                                autocomplete="finca" placeholder="Ej. tipo de cultivo"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('cultivo')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                            
                        </div>
                        <div>
                            <label
                                for="variedad"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Variedad
                            </label>

                            <input id="variedad" name="variedad" type="text" value="{{ old('variedad', $lote?->variedad) }}"
                                autocomplete="variedad" placeholder="Ej. Variedad del cultivo"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('variedad')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                            
                        </div>
                        <div>
                            <label
                                for="peso_prom"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Peso Promedio
                            </label>

                            <input id="peso_prom" name="peso_prom" type="number" step="0.01" value="{{ old('peso_prom', $lote?->peso_prom) }}"
                                autocomplete="peso_prom" placeholder="Ej. Peso promedio del cultivo"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('peso_prom')
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
                        href="{{ route('lotes.index') }}"
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
                        {{ isset($lote) ? 'Actualizar Lote' : 'Crear Lote' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>
