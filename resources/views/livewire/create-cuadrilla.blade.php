<div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

    {{-- Encabezado --}}
    <div class="flex flex-col gap-3 border-b border-zinc-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700">

        <div>
            <flux:heading size="lg">
                Trabajadores asignados a la cuadrilla
            </flux:heading>

            <flux:text size="sm" class="mt-1">
                Administra los trabajadores que pertenecen a esta cuadrilla.
            </flux:text>
        </div>

        <flux:button type="button" variant="primary" class="btn-create" icon="plus" x-on:click="$flux.modal('modal-trabajador').show()">
            Añadir trabajador
        </flux:button>

    </div>

    {{-- Tabla de trabajadores --}}
    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">

            <thead class="bg-zinc-50 dark:bg-zinc-800/70">
                <tr>
                    <th scope="col" class="w-16 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        #
                    </th>

                    <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Nombres
                    </th>

                    <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Apellidos
                    </th>

                    <th scope="col" class="w-24 px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Acciones
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">

                @forelse ( $trabajadores as $trabajador )

                    <tr
                        wire:key="trabajador-{{ $trabajador['id'] }}"
                        class="transition-colors hover:bg-violet-50/50 dark:hover:bg-zinc-800/50"
                    >

                        <th scope="row" class="whitespace-nowrap px-5 py-3.5 text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            {{ $trabajador['id'] }}
                        </th>

                        <td class="whitespace-nowrap px-5 py-3.5 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                            {{ $trabajador['nombres'] }}
                        </td>

                        <td class="whitespace-nowrap px-5 py-3.5 text-sm text-zinc-600 dark:text-zinc-300">
                            {{ $trabajador['apellidos'] }}
                        </td>

                        <td class="whitespace-nowrap px-5 py-3.5 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <flux:button type="button" variant="ghost"
                                    size="sm" icon="trash" color="danger" title="Eliminar"
                                    wire:click="eliminartrabajador({{ $trabajador['id'] }})"/>

                            </div>

                        </td>

                        <input
                            type="hidden"
                            name="trabajadores[{{ $trabajador['id'] }}][id]"
                            value="{{ $trabajador['id'] }}"
                        >

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center">

                            <div class="flex flex-col items-center justify-center gap-2">

                                <div class="flex size-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="users" class="size-6 text-zinc-400" />
                                </div>

                                <flux:heading size="sm">
                                    No hay trabajadores asignados
                                </flux:heading>

                                <flux:text size="sm">
                                    Actualmente no hay trabajadores en esta cuadrilla.
                                </flux:text>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Modal para añadir trabajador --}}
    <flux:modal name="modal-trabajador" class="md:w-120">

        <div class="space-y-6">

            <div>
                <flux:heading size="lg">
                    Añadir trabajador
                </flux:heading>

                <flux:text size="sm" class="mt-1">
                    Selecciona el trabajador que deseas asignar a esta cuadrilla.
                </flux:text>
            </div>

            <div>
                <flux:field>

                    <flux:label for="trabajador_id">
                        Trabajador
                    </flux:label>

                    <flux:select
                        id="trabajador_id"
                        wire:model="trabajadorSeleccionado"
                        placeholder="Seleccione un trabajador..."
                    >
                        <option value="">Seleccione...</option>

                        @foreach($trabajadoresDisponibles as $trabajador)

                            <option value="{{ $trabajador->id }}">
                                {{ $trabajador->nombres }} {{ $trabajador->apellidos }}
                            </option>

                        @endforeach

                    </flux:select>

                </flux:field>
            </div>

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
                    wire:click="agregarTrabajador"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="agregarTrabajador">
                        Añadir trabajador
                    </span>

                    <span wire:loading wire:target="agregarTrabajador">
                        Añadiendo...
                    </span>
                </flux:button>

            </div>

        </div>

    </flux:modal>

</div>
