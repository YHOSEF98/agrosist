@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($labor) && $labor->exists;
    $title = $isEdit ? 'Editar labor' : 'Crear labor';
    $action = $isEdit ? route('labores.update', $labor->id) : route('labores.store');
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
                                <label for="actividad" class="form-label">Actividad</label>
                                <input type="text" class="form-control @error('actividad') is-invalid @enderror"
                                    id="actividad" name="actividad"
                                    value="{{ old('actividad', $labor->actividad ?? '') }}" placeholder="Nombre de la labor a realizar">

                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Unidad de medida y rendimiento esperado -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                <label for="unidad_medida_id" class="form-label">Unidad de medida</label>

                                <select name="unidad_medida_id" id="unidad_medida_id"
                                    class="form-select @error('unidad_medida_id') is-invalid @enderror">

                                    {{-- Siempre mostramos la opción "Seleccione..." --}}
                                    <option value="" 
                                        @selected(!old('unidad_medida_id') && empty($labor?->unidad_medida_id))>
                                        Seleccione...
                                    </option>

                                    @foreach ($unidadesm as $unidad)
                                        <option value="{{ $unidad->id }}" 
                                            @selected(old('unidad_medida_id', $labor->unidad_medida_id ?? '') == $unidad->id)>
                                            {{ $unidad->abrev }} -- {{ $unidad->nombre }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('unidad_medida_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                                <div class="col-md-6 mb-3">
                                    <label for="rendimiento_esperado" class="form-label">Rendimiento esperado</label>
                                    <input type="number"
                                        class="form-control @error('rendimiento_esperado') is-invalid @enderror"
                                        id="rendimiento_esperado" name="rendimiento_esperado" placeholder="Rendimiento esperado por trabajador"
                                        step="0.01" min="0" value="{{ old('rendimiento_esperado', $labor->rendimiento_esperado ?? '') }}">

                                    @error('rendimiento_esperado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- valor unitario, personal directo, contratista -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="valor_unitario" class="form-label">Valor unitario</label>

                                    <input type="number"
                                        class="form-control @error('valor_unitario') is-invalid @enderror"
                                        id="valor_unitario" name="valor_unitario" placeholder="Valor unitario"
                                        step="0.01" min="0" value="{{ old('valor_unitario', $labor->valor_unitario ?? '') }}">

                                    @error('valor_unitario')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tarifa_contratista" class="form-label">Tarifa para personal directo</label>
                                    <input type="number"
                                        class="form-control @error('tarifa_personal_directo') is-invalid @enderror"
                                        id="tarifa_personal_directo" name="tarifa_personal_directo" placeholder="Tarifa del personal directo"
                                        step="0.01" min="0" value="{{ old('tarifa_personal_directo', $labor->tarifa_personal_directo ?? '') }}">

                                    @error('tarifa_personal_directo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="tarifa_contratista" class="form-label">Tarifa para contratista</label>

                                    <input type="number"
                                        class="form-control @error('tarifa_contratista') is-invalid @enderror"
                                        id="tarifa_contratista" name="tarifa_contratista" placeholder="Tarifa para los contratistas"
                                        step="0.01" min="0" value="{{ old('tarifa_contratista', $labor->tarifa_contratista ?? '') }}">


                                    @error('tarifa_contratista')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- valor prestaciones y total -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="valor_prestaciones" class="form-label">Valor de las prestaciones sociales</label>
                                    <input type="number" name="valor_prestaciones" id="valor_prestaciones" 
                                        class="form-control @error('valor_prestaciones') is-invalid @enderror"
                                        step="0.01" min="0" value="{{ old('valor_prestaciones', $labor->valor_prestaciones ?? '') }}">

                                    @error('valor_prestaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="valor_total" class="form-label">Valor total</label>
                                    <input type="number" name="valor_total" id="valor_total" 
                                        class="form-control @error('valor_total') is-invalid @enderror"
                                        step="0.01" min="0" value="{{ old('valor_total', $labor->valor_total ?? '') }}">

                                    @error('valor_total')
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
                                        value="{{ old('observaciones', $labor->observaciones ?? '') }}">

                                    @error('observaciones')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <a href="{{ route('labores.index') }}" class="btn btn-warning">
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