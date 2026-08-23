@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($pluviometro) && $pluviometro->exists;
    $title = $isEdit ? 'Editar pluviómetro' : 'Crear pluviómetro';
    $action = $isEdit ? route('pluviometros.update', $pluviometro->id) : route('pluviometros.store');
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

                            <!-- Campo Nombre -->
                            <div class="mb-3 mt-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre" placeholder="Nombre del pluviometro" name="nombre"
                                    value="{{ old('nombre', $pluviometro->nombre ?? '') }}">

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
                                    id="ubicacion" placeholder="Ubicacion del pluviometro" name="ubicacion"
                                    value="{{ old('ubicacion', $pluviometro->ubicacion ?? '') }}">

                                <!-- Mensaje de error para Ubicacion -->
                                @error('ubicacion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Campo Finca -->
                            <div class="mb-3">
                                <label for="finca_id" class="form-label">Finca:</label>
                                <select class="form-control @error('finca_id') is-invalid @enderror" id="finca_id" name="finca_id">
                                    <option value="">Seleccione una finca</option>
                                    @foreach($fincas as $finca)
                                        <option value="{{ $finca->id }}" {{ old('finca_id', $pluviometro->finca_id ?? '') == $finca->id ? 'selected' : '' }}>
                                            {{ $finca->nombre }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Mensaje de error para Finca -->
                                @error('finca_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Campo Observaciones -->
                            <div class="mb-3 mt-3">
                                <label for="observaciones" class="form-label">Observaciones:</label>
                                <input type="text" class="form-control @error('observaciones') is-invalid @enderror"
                                    id="observaciones" placeholder="Observaciones del pluviometro" name="observaciones"
                                    value="{{ old('observaciones', $pluviometro->observaciones ?? '') }}">

                                <!-- Mensaje de error para Observaciones -->
                                @error('observaciones')
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
