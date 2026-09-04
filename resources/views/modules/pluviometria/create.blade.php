@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($pluviometria) && $pluviometria->exists;
    $title = $isEdit ? 'Editar registro' : 'Crear registro';
    $action = $isEdit ? route('pluviometria.update', $pluviometria->id) : route('pluviometria.store');
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
                            <!-- Actividad -->
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                    id="fecha" name="fecha"
                                    value="{{ old('fecha', $pluviometria->fecha ?? '') }}" placeholder="Fecha de la toma">

                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- pluviometro y cantidad -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="pluviometro_id" class="form-label">Pluviometro</label>

                                    <select name="pluviometro_id" id="pluviometro_id"
                                        class="form-select @error('pluviometro_id') is-invalid @enderror">

                                        {{-- Siempre mostramos la opción "Seleccione..." --}}
                                        <option value="" 
                                            @selected(!old('pluviometro_id') && empty($pluviometria?->pluviometro_id))>
                                            Seleccione...
                                        </option>

                                        @foreach ($pluviometros as $pluviometro)
                                            <option value="{{ $pluviometro->id }}" 
                                                @selected(old('pluviometro_id', $pluviometria->pluviometro_id ?? '') == $pluviometro->id)>
                                                {{ $pluviometro->nombre }} -- {{ $pluviometro->finca->nombre ?? 'N/A' }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('pluviometro_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad - ml</label>
                                    <input type="number"
                                        class="form-control @error('cantidad') is-invalid @enderror"
                                        id="cantidad" name="cantidad" placeholder="Cantidad - ml"
                                        step="0.01" min="0" value="{{ old('cantidad', $pluviometria->cantidad ?? '') }}">

                                    @error('cantidad')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="observaciones" class="form-label">Observaciones:</label>
                                    <input type="text" step="0.01"
                                        class="form-control @error('observaciones') is-invalid @enderror" id="observaciones"
                                        name="observaciones" placeholder="observaciones"
                                        value="{{ old('observaciones', $pluviometria->observaciones ?? '') }}">

                                    @error('observaciones')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <a href="{{ route('pluviometria.index') }}" class="btn btn-warning">
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