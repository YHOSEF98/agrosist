<x-layouts::app :title="$cargo ? __('Editar Cargo') : __('Crear Cargo')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos del Cargo </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos del cargo.</p>

            </div>
            <form method="POST"
                action="{{ isset($cargo) && $cargo
                    ? route('cargos.update', ['current_team' => request()->route('current_team'),'cargo' => $cargo->id,])
                    : route('cargos.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($cargo) && $cargo)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">
                        <x-input-tex-agr
                        name="nombre"
                        label="Nombre"
                        placeholder="Ej. Nombre del cargo"
                        :value="old('nombre', $cargo?->nombre)"
                        required
                        autofocus/>
                        
                        <x-input-tex-agr
                        name="descripcion"
                        label="Descripción"
                        placeholder="Ej. Detalles sobre el cargo"
                        :value="old('descripcion', $cargo?->descripcion)"
                        required
                        autofocus/>

                    </div>

                </div>


                {{-- Acciones --}}
                <div
                    class="flex items-center justify-end gap-3 border-t border-neutral-200
                           px-6 py-4 dark:border-neutral-700">

                    <a
                        href="{{ route('cargos.index') }}"
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
                        {{ isset($cargo) ? 'Actualizar Cargo' : 'Crear Cargo' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>
