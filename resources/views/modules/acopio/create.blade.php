@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($acopio) && $acopio->exists;
    $title = $isEdit ? 'Editar acopio' : 'Crear acopio';
    $action = $isEdit ? route('acopio-edit', $acopio->id) : route('acopio-store');
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
                                    id="nombre" placeholder="Nombre del acopio" name="nombre"
                                    value="{{ old('nombre', $acopio->nombre ?? '') }}">

                                <!-- Mensaje de error para Nombre -->
                                @error('nombre')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Campo estado -->
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado:</label>
                                <select class="form-select @error('estado') is-invalid @enderror" id="estado"
                                    name="estado">
                                    <option value="1"
                                        {{ old('estado', $acopio->estado ?? '') == 1 ? 'selected' : '' }}>Libre</option>
                                    <option value="0"
                                        {{ old('estado', $acopio->estado ?? '') == 0 ? 'selected' : '' }}>Ocupado
                                    </option>
                                </select>

                                @error('estado')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Campo de Selección de Finca -->
                            <div class="mb-3 mt-3">
                                <label for="finca_id" class="form-label">Finca:</label>
                                <select class="form-select @error('finca_id') is-invalid @enderror" id="finca_id"
                                    name="finca_id">
                                    <option value="">-- Seleccione una finca --</option>
                                    @foreach ($fincas as $finca)
                                        <option value="{{ $finca->id }}"
                                            {{ old('finca_id', $lote->finca_id ?? '') == $finca->id ? 'selected' : '' }}>
                                            {{ $finca->nombre }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('finca_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Botones de Acción -->
                            <a href="{{ route('acopios') }}" class="btn btn-warning">
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
