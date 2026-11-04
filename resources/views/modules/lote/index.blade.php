<x-layouts::app :title="__('Lotes')">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        @if (session('success'))
            <x-tarjeta-alerta tipo="success" :mensaje="session('success')" />
        @endif

        @if (session('error'))
            <x-tarjeta-alerta tipo="error" :mensaje="session('error')" />
        @endif

        @if (session('warning'))
            <x-tarjeta-alerta tipo="warning" :mensaje="session('warning')" />
        @endif
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between px-4 py-2 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold">Lotes</h3>
                <x-button-create :href="route('lotes.create')"/>
            </div>
            
            <div x-data="{lote:{nombre: '', url: ''}}" class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 table-auto">
                    <thead class="bg-neutral-100 dark:bg-neutral-800">
                        <tr>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Nombre
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Ubicacion 
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Cultivo 
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Variedad 
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Promedio 
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Finca 
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse ($lotes as $lote)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $lote->nombre }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $lote->ubicacion }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $lote->cultivo }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $lote->variedad }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $lote->peso_prom }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $lote->finca->nombre }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                    <div class="inline-flex items-center gap-2">

                                        <a class="text-blue-600 hover:underline" title="Editar" href="{{ route('lotes.edit', 
                                            ['current_team' => request()->route('current_team'),
                                                'lote' => $lote->id, ]) }}">
                                            <flux:icon.pencil-square class="h-5 w-5 text-blue-600" />
                                        </a>
                                        <flux:button size="xs" class="text-red-600 hover:text-red-800" icon="archive-box-x-mark"
                                            variant="outline" color="red" title="Eliminar"
                                            x-on:click="
                                                lote = {
                                                    nombre: @js($lote->nombre),
                                                    url: @js(route('lotes.destroy', [
                                                        'current_team' => request()->route('current_team'),
                                                        'lote' => $lote->id,
                                                    ])),
                                                };
                                                $flux.modal('delete-lote').show();" >
                                        </flux:button>
                                        <button class="text-green-600 hover:underline" title="Ver Permisos">
                                            <flux:icon.eye class="h-5 w-5 text-green-600" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500">
                                        <div class="flex items-center justify-center gap-2">
                                            <flux:icon.document-arrow-up class="h-6 w-6 text-blue-600 hover:text-blue-800" />
                                            <span>Actualmente no hay Lotes registrados.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
                <flux:modal name="delete-lote" class="min-w-[22rem]">
                <form method="POST" x-bind:action="lote.url" class="space-y-6">
                    @csrf
                    @method('DELETE')

                    <div>
                        <flux:heading size="lg">¿Eliminar el lote <span x-text="lote.nombre"></span>?</flux:heading>

                        <flux:text class="mt-2">
                            Está a punto de eliminar el lote
                            <strong>"<span x-text="lote.nombre"></span>"</strong>.<br>
                            Esta acción no se puede deshacer.
                        </flux:text>
                    </div>

                    <div class="flex gap-2">
                        <flux:spacer />

                        <flux:modal.close>
                            <flux:button variant="ghost">Cancelar</flux:button>
                        </flux:modal.close>

                        <flux:button type="submit" variant="danger">Eliminar lote</flux:button>
                    </div>
                </form>
            </flux:modal>
            </div>

        </div>
    </div>
    
</x-layouts::app>