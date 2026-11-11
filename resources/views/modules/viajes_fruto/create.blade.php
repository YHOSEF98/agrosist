<x-layouts::app :title="$viaje ? __('Editar Viaje de fruto') : __('Crear Viaje de fruto')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos de viaje </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos del viaje de fruto.</p>

            </div>
                @livewire('modules.viajes-fruto', ['viaje' => $viaje?->id])


        </div>

    </div>

</x-layouts::app>