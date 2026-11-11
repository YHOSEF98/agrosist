<x-layouts::app :title="$remision ? __('Editar Remisión') : __('Crear Remisión')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos de la Remisión </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos de la salida del fruto.</p>

            </div>
                @livewire('modules.alcefruto', [
                    'remision' => $remision?->id
                ])


        </div>

    </div>

</x-layouts::app>