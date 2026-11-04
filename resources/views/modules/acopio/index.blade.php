<x-layouts::app :title="__('Acopios')">

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
                <h3 class="text-lg font-semibold">Acopios</h3>
                <x-button-create :href="route('acopios.create')"/>
            </div>
            
            <div x-data="{acopio:{nombre: '', url: ''}}" class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 table-auto">
                    <thead class="bg-neutral-100 dark:bg-neutral-800">
                        <tr>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Nombre
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Estado 
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Finca 
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse ($acopios as $acopio)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $acopio->nombre }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ $acopio->estado
                                            ? 'bg-red-100 text-red-700'
                                            : 'bg-green-100 text-green-700' }}">
                                        {{ $acopio->estado ? 'Ocupado' : 'Libre' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $acopio->finca->nombre }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                    <div class="inline-flex items-center gap-2">

                                        <a class="text-blue-600 hover:underline" title="Editar" href="{{ route('acopios.edit', 
                                            ['current_team' => request()->route('current_team'),
                                                'acopio' => $acopio->id, ]) }}">
                                            <flux:icon.pencil-square class="h-5 w-5 text-blue-600" />
                                        </a>
                                        <flux:button size="xs" class="text-red-600 hover:text-red-800" icon="archive-box-x-mark"
                                            variant="outline" color="red" title="Eliminar"
                                            x-on:click="
                                                acopio = {
                                                    nombre: @js($acopio->nombre),
                                                    url: @js(route('acopios.destroy', [
                                                        'current_team' => request()->route('current_team'),
                                                        'acopio' => $acopio->id,
                                                    ])),
                                                };
                                                $flux.modal('delete-acopio').show();" >
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
                                            <span>Actualmente no hay Acopios registrados.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
                <flux:modal name="delete-acopio" class="min-w-[22rem]">
                <form method="POST" x-bind:action="acopio.url" class="space-y-6">
                    @csrf
                    @method('DELETE')

                    <div>
                        <flux:heading size="lg">¿Eliminar el acopio <span x-text="acopio.nombre"></span>?</flux:heading>

                        <flux:text class="mt-2">
                            Está a punto de eliminar el acopio
                            <strong>"<span x-text="acopio.nombre"></span>"</strong>.<br>
                            Esta acción no se puede deshacer.
                        </flux:text>
                    </div>

                    <div class="flex gap-2">
                        <flux:spacer />

                        <flux:modal.close>
                            <flux:button variant="ghost">Cancelar</flux:button>
                        </flux:modal.close>

                        <flux:button type="submit" variant="danger">Eliminar acopio</flux:button>
                    </div>
                </form>
            </flux:modal>
            </div>

        </div>
    </div>
    
</x-layouts::app>