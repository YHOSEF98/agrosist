@php
    $isEdit = isset($cuadrilla) && $cuadrilla->exists;
    $title = $isEdit ? 'Editar cuadrilla' : 'Crear cuadrilla';
    $action = $isEdit ? route('cuadrillas.update', $cuadrilla->id) : route('cuadrillas.store');

    // Preparamos los trabajadores seleccionados según el contexto
    $trabajadoresSeleccionados = old(
        'trabajadores',
        $isEdit ? $cuadrilla->trabajadores->pluck('id')->toArray() : []
    );
@endphp

<x-base :title="$title">
    <div class="row">
        <div class="app-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ $action }}" method="POST">
                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif
                            <!-- Fecha y nombre -->

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" wire:model="fecha"
                                    class="form-control @error('fecha') is-invalid @enderror"
                                    value="{{ old('fecha', $cuadrilla->fecha ?? '') }}"
                                    onchange="Livewire.dispatch('fechaActualizada', { fecha: this.value })">
                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="nombre" class="form-label">Nombre de la cuadrilla</label>
                                <input type="text" id="nombre" name="nombre"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ old('nombre', $cuadrilla->nombre ?? '') }}">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                </div>
                                <!-- Labor asociada -->
                            <div class="col-md-4 mb-3">
                                <label for="labore_id" class="form-label">Labor</label>
                                <select id="labore_id" name="labore_id"
                                    class="form-select @error('labore_id') is-invalid @enderror">
                                    <option value=""
                                        @selected(!old('labore_id') && empty($cuadrilla?->labore_id))>
                                        Seleccione...
                                    </option>
                                    @foreach ($labores as $labor)
                                        <option value="{{ $labor->id }}"
                                            @selected(old('labore_id', $cuadrilla->labore_id ?? '') == $labor->id)>
                                            {{ $labor->actividad }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('labore_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>

                            <!-- Observación -->
                            <div class="mb-3">
                                <label for="observacion" class="form-label">Observación</label>
                                <textarea id="observacion" name="observacion"
                                    class="form-control @error('observacion') is-invalid @enderror">{{ old('observacion', $cuadrilla->observacion ?? '') }}</textarea>
                                @error('observacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @livewire('create-cuadrilla', [
                                    'fechaInicial' => old('fecha', $cuadrilla->fecha ?? ''),
                                    'trabajadoresIniciales' => old(
                                    'trabajadores',
                                    $isEdit ? $cuadrilla->trabajadores->map(fn($t) => [
                                        'id' => $t->id,
                                        'nombres' => $t->nombres,
                                        'apellidos' => $t->apellidos,
                                        'fecha' => $t->pivot->fecha, // si quieres mostrar la fecha del pivot
                                    ])->toArray() : [])
                                ])

                            <a href="{{ route('cuadrillas.index') }}" class="btn btn-warning">
                                <i class="bi bi-arrow-left-short"></i> Volver
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Guardar
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base>
