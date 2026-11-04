<x-layouts::app :title="$empresa ? __('Editar Empresa') : __('Crear Empresa')">

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
                action="{{ isset($empresa) && $empresa
                    ? route('empresa.update', ['current_team' => request()->route('current_team'),'empresa' => $empresa->id,])
                    : route('empresa.store', ['current_team' => request()->route('current_team'),]) }}">

                @csrf

                @if(isset($empresa) && $empresa)
                    @method('PUT')
                @endif

                {{-- Contenido --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">


                        {{-- Equipo --}}
                        <div>
                            <label
                                for="team_id"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Equipo
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
                                       dark:focus:border-violet-500"
                            >
                                <option value="">
                                    Seleccione un equipo
                                </option>

                                @foreach($teams as $team)
                                    <option
                                        value="{{ $team->id }}"
                                        @selected(old('team_id', $empresa?->team_id) == $team->id)
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


                        {{-- Razón Social --}}
                        <div>
                            <label
                                for="razon_social"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Razón Social
                            </label>

                            <input
                                id="razon_social"
                                name="razon_social"
                                type="text"
                                value="{{ old('razon_social', $empresa?->razon_social) }}"
                                required
                                autofocus
                                autocomplete="organization"
                                placeholder="Ej. Palmeras del Nispero S.A.S."
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('razon_social')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Nombre Comercial --}}
                        <div>
                            <label
                                for="nombre_comercial"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Nombre Comercial
                            </label>

                            <input
                                id="nombre_comercial"
                                name="nombre_comercial"
                                type="text"
                                value="{{ old('nombre_comercial', $empresa?->nombre_comercial) }}"
                                autocomplete="organization"
                                placeholder="Ej. Palmeras del Nispero"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('nombre_comercial')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


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

                                @foreach($tiposDocumento as $tipo)
                                    <option
                                        value="{{ $tipo->id }}"
                                        @selected(old('tipo_documento_id', $empresa?->tipo_documento_id) == $tipo->id)
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


                        {{-- Número Documento --}}
                        <div>
                            <label
                                for="numero_documento"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Número de Documento
                            </label>

                            <input
                                id="numero_documento"
                                name="numero_documento"
                                type="text"
                                inputmode="numeric"
                                value="{{ old('numero_documento', $empresa?->numero_documento) }}"
                                required
                                placeholder="Ej. 900123456"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('numero_documento')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Dígito Verificación --}}
                        <div>
                            <label
                                for="digito_verificacion"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Dígito de Verificación
                            </label>

                            <input
                                id="digito_verificacion"
                                name="digito_verificacion"
                                type="text"
                                inputmode="numeric"
                                maxlength="1"
                                value="{{ old('digito_verificacion', $empresa?->digito_verificacion) }}"
                                placeholder="Ej. 5"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('digito_verificacion')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Dirección --}}
                        <div>
                            <label
                                for="direccion"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Dirección
                            </label>

                            <input
                                id="direccion"
                                name="direccion"
                                type="text"
                                value="{{ old('direccion', $empresa?->direccion) }}"
                                autocomplete="street-address"
                                placeholder="Dirección de la empresa"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('direccion')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Teléfono --}}
                        <div>
                            <label
                                for="telefono"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Teléfono
                            </label>

                            <input
                                id="telefono"
                                name="telefono"
                                type="text"
                                inputmode="tel"
                                value="{{ old('telefono', $empresa?->telefono) }}"
                                autocomplete="tel"
                                placeholder="Ej. 300 123 4567"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('telefono')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Correo --}}
                        <div class="md:col-span-2">
                            <label
                                for="email"
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            >
                                Correo Electrónico
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $empresa?->email) }}"
                                autocomplete="email"
                                placeholder="correo@empresa.com"
                                class="mt-1.5 block w-full rounded-lg border border-neutral-300
                                       bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-sm
                                       outline-none transition
                                       placeholder:text-neutral-400
                                       focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20
                                       dark:border-neutral-700 dark:bg-neutral-800
                                       dark:text-neutral-100 dark:placeholder-neutral-500
                                       dark:focus:border-violet-500"
                            >

                            @error('email')
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
                        href="{{ route('empresa.index') }}"
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
                        {{ isset($company) ? 'Actualizar Empresa' : 'Guardar Empresa' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>