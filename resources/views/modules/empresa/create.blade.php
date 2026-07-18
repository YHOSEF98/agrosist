@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($empresa) && $empresa->exists;
    $title = $isEdit ? 'Editar empresa' : 'Crear empresa';
    $action = $isEdit ? route('empresa-edit', $empresa->id) : route('empresa-store');
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
                                    id="nombre" placeholder="Nombre de la empresa" name="nombre"
                                    value="{{ old('nombre', $empresa->nombre ?? '') }}">

                                <!-- Mensaje de error para Nombre -->
                                @error('nombre')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Campo NIT -->
                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT:</label>
                                <input type="text" class="form-control @error('nit') is-invalid @enderror"
                                    id="nit" placeholder="NIT de la empresa" name="nit"
                                    value="{{ old('nit', $empresa->nit ?? '') }}">

                                <!-- Mensaje de error para NIT -->
                                @error('nit')
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
