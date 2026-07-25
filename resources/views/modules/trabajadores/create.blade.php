@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($trabajador) && $trabajador->exists;
    $title = $isEdit ? 'Editar trabajador' : 'Crear trabajador';
    $action = $isEdit ? route('trabajadores.update', $trabajador->id) : route('trabajadores.store');
@endphp
<x-base :title="$title">
    <div class="row">
        <div class="app-content" bis_skin_checked="1">
            <div class="container-fluid" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-header" bis_skin_checked="1">
                        <h3 class="card-title">{{ $title }}</h3>

                    </div>
                    <div class="card-body">

                        <form action="{{ $action }}" method="POST">
                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif

                            <!-- Nombres y Apellidos -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombres" class="form-label">Nombres</label>
                                    <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                                        id="nombres" name="nombres" placeholder="Nombres"
                                        value="{{ old('nombres', $trabajador->nombres ?? '') }}">

                                    @error('nombres')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                                        id="apellidos" name="apellidos" placeholder="Apellidos"
                                        value="{{ old('apellidos', $trabajador->apellidos ?? '') }}">

                                    @error('apellidos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tipo y Número de documento -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tipo_documento" class="form-label">Tipo de documento</label>

                                    <select name="tipo_documento" id="tipo_documento"
                                        class="form-select @error('tipo_documento') is-invalid @enderror">

                                        <option value="">Seleccione...</option>

                                        @foreach (\App\Enums\TipoDocumento::cases() as $tipo)
                                            <option value="{{ $tipo->value }}" @selected(old('tipo_documento', $trabajador->tipo_documento->value ?? '') == $tipo->value)>
                                                {{ $tipo->label() }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('tipo_documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label for="numero_documento" class="form-label">Número de documento</label>

                                    <input type="text"
                                        class="form-control @error('numero_documento') is-invalid @enderror"
                                        id="numero_documento" name="numero_documento" placeholder="Número de documento"
                                        value="{{ old('numero_documento', $trabajador->numero_documento ?? '') }}">

                                    @error('numero_documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de nacimiento y Fecha de ingreso -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                                    <input type="date"
                                        class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                        id="fecha_nacimiento" name="fecha_nacimiento"
                                        value="{{ old('fecha_nacimiento', $trabajador->fecha_nacimiento ?? '') }}">

                                    @error('fecha_nacimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
                                    <input type="date"
                                        class="form-control @error('fecha_ingreso') is-invalid @enderror"
                                        id="fecha_ingreso" name="fecha_ingreso"
                                        value="{{ old('fecha_ingreso', $trabajador->fecha_ingreso ?? '') }}">

                                    @error('fecha_ingreso')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email y Teléfono -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email"
                                        value="{{ old('email', $trabajador->email ?? '') }}">

                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                        id="telefono" name="telefono"
                                        value="{{ old('telefono', $trabajador->telefono ?? '') }}">

                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                                    id="direccion" name="direccion"
                                    value="{{ old('direccion', $trabajador->direccion ?? '') }}">

                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Persona contacto y Teléfono -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="persona_contacto" class="form-label">Contacto de emergencia</label>
                                    <input type="text"
                                        class="form-control @error('persona_contacto') is-invalid @enderror"
                                        id="persona_contacto" name="persona_contacto"
                                        value="{{ old('persona_contacto', $trabajador->persona_contacto ?? '') }}">

                                    @error('persona_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telefono_persona_contacto" class="form-label">Teléfono</label>
                                    <input type="text"
                                        class="form-control @error('telefono_persona_contacto') is-invalid @enderror"
                                        id="telefono_persona_contacto" name="telefono_persona_contacto"
                                        value="{{ old('telefono', $trabajador->telefono ?? '') }}">

                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Cargo y Empresa -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cargo_id" class="form-label">Cargo:</label>

                                    <select name="cargo_id" id="cargo_id"
                                        class="form-select @error('cargo_id') is-invalid @enderror">

                                        <option value="">Seleccione un cargo</option>

                                        @foreach ($cargos as $cargo)
                                            <option value="{{ $cargo->id }}" @selected(old('cargo_id', $trabajador->cargo_id ?? '') == $cargo->id)>
                                                {{ $cargo->nombre }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('cargo_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="empresa_id" class="form-label">Empresa:</label>

                                    <select name="empresa_id" id="empresa_id"
                                        class="form-select @error('empresa_id') is-invalid @enderror">

                                        <option value="">Seleccione una empresa</option>

                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id }}" @selected(old('empresa_id', $trabajador->empresa_id ?? '') == $empresa->id)>
                                                {{ $empresa->nombre }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('empresa_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Salario y Auxilio -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="salario" class="form-label">Salario:</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('salario') is-invalid @enderror" id="salario"
                                        name="salario" placeholder="Salario"
                                        value="{{ old('salario', $trabajador->salario ?? '') }}">

                                    @error('salario')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="aux_transporte" class="form-label">Auxilio de transporte:</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('aux_transporte') is-invalid @enderror"
                                        id="aux_transporte" name="aux_transporte" placeholder="Auxilio de transporte"
                                        value="{{ old('aux_transporte', $trabajador->aux_transporte ?? '') }}">

                                    @error('aux_transporte')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <a href="{{ route('trabajadores.index') }}" class="btn btn-warning">
                                <i class="bi bi-arrow-left-short"></i> Volver
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Guardar
                            </button>

                        </form>

                    </div>
                    <div class="card-footer text-secondary small" bis_skin_checked="1">
                        Volar al
                        <a href="#" target="_blank" rel="noopener">Dashboard</a>
                    </div>
</x-base>
