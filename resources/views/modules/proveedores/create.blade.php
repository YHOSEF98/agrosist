<x-layouts::app :title="$proveedore ? __('Editar Proveedor') : __('Crear Proveedor')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos del Proveedor </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos del proveedor.</p>

            </div>
            <form method="POST"
                action="{{ isset($proveedore) && $proveedore
                    ? route('proveedores.update', ['current_team' => request()->route('current_team'),'proveedore' => $proveedore->id,])
                    : route('proveedores.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($proveedore) && $proveedore)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">
                        <x-input-tex-agr
                        name="razon_social"
                        label="Razón Social"
                        placeholder="Ej. Razón social del proveedor"
                        :value="old('razon_social', $proveedore?->razon_social)"
                        required
                        autofocus/>
                        
                        <x-input-tex-agr
                        name="nombre_comercial"
                        label="Nombre Comercial"
                        placeholder="Ej. Nombre comercial del proveedor"
                        :value="old('nombre_comercial', $proveedore?->nombre_comercial)"
                        autofocus/>

                        {{-- Tipo Documento --}}
                        <div>
                            <label
                                for="tipo_documento_id"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Tipo de Documento
                            </label>

                            <select
                                id="tipo_documento_id"
                                name="tipo_documento_id"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100
                                       dark:focus:border-violet-500"
                            >
                                <option value="">
                                    Seleccione un tipo de documento
                                </option>

                                @foreach($tiposDocumentos as $tipo)
                                    <option
                                        value="{{ $tipo->id }}"
                                        @selected(old('tipo_documento_id', $proveedore ?->tipo_documento_id) == $tipo->id)
                                    >
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @error('tipo_documento_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <x-input-tex-agr
                        name="numero_documento"
                        label="Número de Documento"
                        placeholder="Ej. 123456789"
                        type="number"
                        :value="old('numero_documento', $proveedore?->numero_documento)"
                        required
                        autofocus/>
                        <x-input-tex-agr
                        name="digito_verificacion"
                        label="Dígito de Verificación"
                        placeholder="Ej. 1"
                        type="number"
                        :value="old('digito_verificacion', $proveedore?->digito_verificacion)"
                        autofocus/>
                        <x-input-tex-agr
                        name="direccion"
                        label="Dirección"
                        placeholder="Ej. Dirección del proveedor"
                        :value="old('direccion', $proveedore?->direccion)"
                        autofocus/>
                        <x-input-tex-agr
                        name="telefono"
                        label="Teléfono"
                        placeholder="Ej. 123456789"
                        :value="old('telefono', $proveedore?->telefono)"
                        autofocus/>
                        <x-input-tex-agr
                        name="email"
                        label="Email"
                        placeholder="Ej. email@proveedor.com"
                        type="email"
                        :value="old('email', $proveedore?->email)"
                        autofocus/>

                        <div>
                            <input type="hidden" name="es_cliente" value="0">
                            <flux:field>
                                <flux:label>Es Cliente</flux:label>

                                <flux:switch
                                    name="es_cliente"
                                    value="1"
                                    :checked="old('es_cliente', $proveedore?->es_cliente)"
                                />

                                <flux:error name="es_cliente" />
                            </flux:field>

                            @error('es_cliente')
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
                           px-6 py-4 dark:border-neutral-700">

                    <a
                        href="{{ route('proveedores.index') }}"
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
                        {{ isset($proveedore) ? 'Actualizar Proveedor' : 'Crear Proveedor' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>
