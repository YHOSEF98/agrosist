<x-layouts::app :title="$finca ? __('Editar Finca') : __('Crear Finca')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos empresariales </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos de la empresa.</p>

            </div>
            <form method="POST"
                action="{{ isset($finca) && $finca
                    ? route('fincas.update', ['current_team' => request()->route('current_team'),'finca' => $finca->id,])
                    : route('fincas.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($finca) && $finca)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">


                        {{-- Equipo --}}
                        <div>
                            <label for="team_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Empresa a la que pertenece </label>

                            <select
                                id="team_id"
                                name="team_id"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100
                                       dark:focus:border-violet-500"
                            >
                                <option value="">
                                    Seleccione un equipo
                                </option>

                                @foreach($teams as $team)
                                    <option
                                        value="{{ $team->id }}"
                                        @selected(old('team_id', $finca?->team_id) == $team->id)
                                    >
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('team_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Nombre
                             </label>

                            <input id="nombre" name="nombre" type="text" value="{{ old('nombre', $finca?->nombre) }}"
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
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Ubicación
                            </label>

                            <input id="ubicacion" name="ubicacion" type="text" value="{{ old('ubicacion', $finca?->ubicacion) }}"
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

                    </div>

                </div>


                {{-- Acciones --}}
                <div
                    class="flex items-center justify-end gap-3 border-t border-neutral-200
                           px-6 py-4 dark:border-neutral-700"
                >

                    <a
                        href="{{ route('fincas.index') }}"
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
                        {{ isset($finca) ? 'Actualizar Finca' : 'Crear Finca' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>