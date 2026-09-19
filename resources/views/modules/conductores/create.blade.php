@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($conductor) && $conductor->exists;
    $title = $isEdit ? 'Editar conductor' : 'Crear conductor';
    $action = $isEdit ? route('conductores.update', $conductor->id) : route('conductores.store');
@endphp
<x-base :title="$title">
    <div class="row">
        <div class="app-content" bis_skin_checked="1">
            <div class="container-fluid" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-header" bis_skin_checked="1">
                        <h3 class="card-title">{{ $title }}</h3>

                    </div>
                    <div class="card-body" bis_skin_checked="1">


                        <form action="{{ $action }}" method="POST">
                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Campo Proveedor -->
                                <div class="col-md-4 mb-3">
                                    <label for="provedore_id" class="form-label">Proveedor:</label>
                                    <select name="provedore_id" id="provedore_id"
                                        class="form-select @error('provedore_id') is-invalid @enderror">
                                        <option value="">Seleccione un proveedor...</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" @selected(old('provedore_id', $conductor->provedore_id ?? '') == $proveedor->id)>
                                                {{ $proveedor->razon_social }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('provedore_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="tipo_documento" class="form-label">Tipo de documento</label>

                                    <select name="tipo_documento" id="tipo_documento"
                                        class="form-select @error('tipo_documento') is-invalid @enderror">

                                        <option value="">Seleccione...</option>

                                        @foreach (\App\Enums\TipoDocumento::cases() as $tipo)
                                            <option value="{{ $tipo->value }}" @selected(old('tipo_documento', $conductor->tipo_documento?->value ?? '') == $tipo->value)>
                                                {{ $tipo->label() }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('tipo_documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="documento" class="form-label">Numero de documento:</label>
                                    <input type="number"  step="any"
                                        class="form-control @error('documento') is-invalid @enderror" id="documento"
                                        name="documento" placeholder="Numero de documento"
                                        value="{{ old('documento', $conductor->documento ?? '') }}">

                                    @error('documento')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="placa" class="form-label">Placa:</label>
                                    <input type="text" class="form-control @error('placa') is-invalid @enderror"
                                        id="placa" placeholder="Placa del vehículo" name="placa"
                                        value="{{ old('placa', $conductor->placa ?? '') }}">

                                    @error('placa')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <!-- Campo nombres -->
                                <div class="col-md-6 mb-3">
                                    <label for="nombres" class="form-label">Nombres:</label>
                                    <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                                        id="nombres" placeholder="Nombres del conductor" name="nombres"
                                        value="{{ old('nombres', $conductor->nombres ?? '') }}">

                                    <!-- Mensaje de error para Nombres -->
                                    @error('nombres')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label">Apellidos:</label>
                                    <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                                        id="apellidos" placeholder="Apellidos del conductor" name="apellidos"
                                        value="{{ old('apellidos', $conductor->apellidos ?? '') }}">

                                    <!-- Mensaje de error para Apellidos -->
                                    @error('apellidos')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Botones de Acción -->
                            <a href="{{ route('conductores.index') }}" class="btn btn-warning">
                                <i class="bi bi-arrow-left-short"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Guardar
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-secondary small" bis_skin_checked="1">
                        Volar al
                        <a href="#" target="_blank" rel="noopener">Dashboard</a>
                    </div>
</x-base>
