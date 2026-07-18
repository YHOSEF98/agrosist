@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($finca) && $finca->exists;
    $title = $isEdit ? 'Editar finca' : 'Crear finca';
    $action = $isEdit ? route('finca-edit', $finca->id) : route('finca-store');
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

                            <!-- Campo Nombre -->
                            <div class="mb-3 mt-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre" placeholder="Nombre de la finca" name="nombre"
                                    value="{{ old('nombre', $finca->nombre ?? '') }}">

                                <!-- Mensaje de error para Nombre -->
                                @error('nombre')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Campo Ubicacion -->
                            <div class="mb-3">
                                <label for="ubicacion" class="form-label">Ubicacion:</label>
                                <input type="text" class="form-control @error('ubicacion') is-invalid @enderror"
                                    id="ubicacion" placeholder="Ubicacion de la finca" name="ubicacion"
                                    value="{{ old('ubicacion', $finca->ubicacion ?? '') }}">

                                <!-- Mensaje de error para NIT -->
                                @error('nit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Campo de Selección de Empresa -->
                            <div class="mb-3 mt-3">
                                <label for="empresa_id" class="form-label">Empresa vinculada:</label>
                                <select class="form-select @error('empresa_id') is-invalid @enderror" id="empresa_id"
                                    name="empresa_id">
                                    <option value="">-- Seleccione una empresa --</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id }}"
                                            {{ old('empresa_id', $finca->empresa_id ?? '') == $empresa->id ? 'selected' : '' }}>
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

                            <!-- Botones de Acción -->
                            <a href="{{ route('empresa') }}" class="btn btn-warning">
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
