@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($lote) && $lote->exists;
    $title = $isEdit ? 'Editar lote' : 'Crear lote';
    $action = $isEdit ? route('lote-edit', $lote->id) : route('lote-store');
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
                                    id="nombre" placeholder="Nombre del lote" name="nombre"
                                    value="{{ old('nombre', $lote->nombre ?? '') }}">

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
                                    id="ubicacion" placeholder="Ubicacion del lote" name="ubicacion"
                                    value="{{ old('ubicacion', $lote->ubicacion ?? '') }}">

                                <!-- Mensaje de error para Ubicacion -->
                                @error('ubicacion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Campo Cultivo -->
                            <div class="mb-3">
                                <label for="cultivo" class="form-label">Cultivo:</label>
                                <input type="text" class="form-control @error('cultivo') is-invalid @enderror"
                                    id="cultivo" placeholder="Cultivo del lote" name="cultivo"
                                    value="{{ old('cultivo', $lote->cultivo ?? '') }}">

                                <!-- Mensaje de error para Cultivo -->
                                @error('cultivo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Campo Variedad -->
                            <div class="mb-3">
                                <label for="variedad" class="form-label">Variedad:</label>
                                <input type="text" class="form-control @error('variedad') is-invalid @enderror"
                                    id="variedad" placeholder="Variedad del lote" name="variedad"
                                    value="{{ old('variedad', $lote->variedad ?? '') }}">

                                <!-- Mensaje de error para Variedad -->
                                @error('variedad')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Campo Peso promedio -->
                            <div class="mb-3">
                                <label for="peso_prom" class="form-label">Peso promedio:</label>
                                <input type="number" step="0.01" min="0"
                                    class="form-control @error('peso_prom') is-invalid @enderror" id="peso_prom"
                                    placeholder="0.00" name="peso_prom"
                                    value="{{ old('peso_prom', $lote->peso_prom ?? '') }}">

                                <!-- Mensaje de error para Peso promedio -->
                                @error('peso_prom')
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
                            <a href="{{ route('lotes') }}" class="btn btn-warning">
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
