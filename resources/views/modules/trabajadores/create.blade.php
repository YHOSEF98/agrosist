<x-layouts::app :title="$trabajador ? __('Editar trabajador') : __('Crear trabajador')">

    <div class="flex h-full w-full flex-1 flex-col gap-4">

        {{-- Contenedor principal --}}
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            {{-- Encabezado --}}
            <div class="border-b border-neutral-200 px-6 py-5 dark:border-neutral-700">

                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100"> Datos del trabajador </h2>

                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Completa los datos básicos del trabajador.</p>

            </div>
            <form method="POST"
                action="{{ isset($trabajador) && $trabajador
                    ? route('trabajadores.update', ['current_team' => request()->route('current_team'),'trabajador' => $trabajador->id,])
                    : route('trabajadores.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($trabajador) && $trabajador)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">
                        <x-input-tex-agr name="nombres" label="Nombres" placeholder="Ej. Juan Pérez"
                        :value="old('nombres', $trabajador?->nombres)" required autofocus/>

                        <x-input-tex-agr name="apellidos" label="Apellidos" placeholder="Ej. García López"
                            :value="old('apellidos', $trabajador?->apellidos)" required />
                        <div>
                            <label
                                for="tipo_documento_id"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Tipo de documento
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

                                @foreach($tipos_documento as $tipo)
                                    <option
                                        value="{{ $tipo->id }}"
                                        @selected(old('tipo_documento_id', $trabajador?->tipo_documento_id) == $tipo->id)>
                                        {{ $tipo->nombre }} - {{ $tipo->abreviatura }}
                                    </option>
                                @endforeach
                            </select>

                            @error('tipo_documento_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <x-input-tex-agr name="numero_documento" label="Número de Documento" placeholder="Ej. 123456789"
                            :value="old('numero_documento', $trabajador?->numero_documento)" required />

                        <x-input-tex-agr name="fecha_ingreso" label="Fecha de Ingreso" placeholder="Ej. 2023-01-01"
                            :value="old('fecha_ingreso', $trabajador?->fecha_ingreso)" type="date" required />

                        <x-input-tex-agr name="email" label="Email" placeholder="Ej. juan.garcia@example.com" type="email"
                            :value="old('email', $trabajador?->email)" required />                        

                        <x-input-tex-agr name="fecha_nacimiento" label="Fecha de Nacimiento" placeholder="Ej. 2000-01-01" type="date"
                        :value="old('fecha_nacimiento', $trabajador?->fecha_nacimiento)" />

                        <x-input-tex-agr name="telefono" label="Teléfono" placeholder="Ej. 3161234567" type="text"
                        :value="old('telefono', $trabajador?->telefono)" />

                        <x-input-tex-agr name="direccion" label="Dirección" placeholder="Ej. Calle 123"
                        :value="old('direccion', $trabajador?->direccion)" />

                        <x-input-tex-agr name="persona_contacto" label="Persona de Contacto" placeholder="Ej. María López" type="text"
                        :value="old('persona_contacto', $trabajador?->persona_contacto)" />

                        <x-input-tex-agr name="telefono_persona_contacto" label="Teléfono de Contacto" placeholder="Ej. 3161234567" type="text"
                        :value="old('telefono_persona_contacto', $trabajador?->telefono_persona_contacto)" />

                        <div>
                            <label
                                for="cargo_id"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Cargo
                            </label>

                            <select
                                id="cargo_id"
                                name="cargo_id"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100
                                       dark:focus:border-violet-500">
                                <option value="">
                                    Seleccione un cargo
                                </option>

                                @foreach($cargos as $cargo)
                                    <option
                                        value="{{ $cargo->id }}"
                                        @selected(old('cargo_id', $trabajador?->cargo_id) == $cargo->id)>
                                        {{ $cargo->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @error('cargo_id')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <x-input-tex-agr name="salario" label="Salario" placeholder="Ej. 100.00" type="number" step="0.01"
                        :value="old('salario', $trabajador?->salario)" autofocus/>

                        <x-input-tex-agr name="aux_transporte" label="Auxilio de Transporte" placeholder="Ej. 100.00" type="number" step="0.01"
                        :value="old('aux_transporte', $trabajador?->aux_transporte)" autofocus/>

                        <div>
                            <input type="hidden" name="estatus" value="Inactivo">
                            <flux:field>
                                <flux:label>Estado</flux:label>

                                <flux:switch
                                    name="estatus"
                                    value="Activo"
                                    :checked="old('estatus', $trabajador?->estatus) == 'Activo'"
                                />

                                <flux:error name="estatus" />
                            </flux:field>

                            @error('estatus')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label
                                for="team_id"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Empresa
                            </label>

                            <select
                                id="team_id"
                                name="team_id"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100
                                       dark:focus:border-violet-500">
                                <option value="">
                                    Seleccione una empresa
                                </option>

                                @foreach($teams as $team)
                                    <option
                                        value="{{ $team->id }}"
                                        @selected(old('team_id', $trabajador?->team_id) == $team->id)>
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
                    </div>

                    </div>

                </div>


                {{-- Acciones --}}
                <div
                    class="flex items-center justify-end gap-3 border-t border-neutral-200
                           px-6 py-4 dark:border-neutral-700"
                >

                    <a
                        href="{{ route('trabajadores.index') }}"
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
                        {{ isset($trabajador) ? 'Actualizar Trabajador' : 'Crear Trabajador' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>
