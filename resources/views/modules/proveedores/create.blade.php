@php
    // Detectamos dinámicamente la ruta y el método
    $isEdit = isset($proveedor) && $proveedor->exists;
    $title = $isEdit ? 'Editar proveedor' : 'Crear proveedor';
    $action = $isEdit ? route('proveedores.update', $proveedor->id) : route('proveedores.store');
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

                            <div class="row">
                                <!-- Campo Razon social -->
                                <div class="col-md-6 mb-3">
                                    <label for="razon_social" class="form-label">Razon social:</label>
                                    <input type="text" class="form-control @error('razon_social') is-invalid @enderror"
                                        id="razon_social" placeholder="Razon social del proveedor" name="razon_social"
                                        value="{{ old('razon_social', $proveedor->razon_social ?? '') }}">

                                    <!-- Mensaje de error para Razon social -->
                                    @error('razon_social')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nombre_comercial" class="form-label">Nombre comercial:</label>
                                    <input type="text" class="form-control @error('nombre_comercial') is-invalid @enderror"
                                        id="nombre_comercial" placeholder="Nombre comercial del proveedor" name="nombre_comercial"
                                        value="{{ old('nombre_comercial', $proveedor->nombre_comercial ?? '') }}">

                                    <!-- Mensaje de error para Nombre comercial -->
                                    @error('nombre_comercial')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Tipo de contribuyente -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tipo_contribuyente" class="form-label">Tipo de contribuyente</label>

                                    <select name="tipo_contribuyente" id="tipo_contribuyente"
                                        class="form-select @error('tipo_contribuyente') is-invalid @enderror">

                                        <option value="">Seleccione...</option>

                                        @foreach (\App\Enums\TipoContribuyente::cases() as $tipo)
                                            <option value="{{ $tipo->value }}" @selected(old('tipo_contribuyente', $proveedor->tipo_contribuyente?->value ?? '') == $tipo->value)>
                                                {{ $tipo->label() }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('tipo_contribuyente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="tipo_documento" class="form-label">Tipo de documento</label>

                                    <select name="tipo_documento" id="tipo_documento"
                                        class="form-select @error('tipo_documento') is-invalid @enderror">

                                        <option value="">Seleccione...</option>

                                        @foreach (\App\Enums\TipoDocumento::cases() as $tipo)
                                            <option value="{{ $tipo->value }}" @selected(old('tipo_documento', $proveedor->tipo_documento?->value ?? '') == $tipo->value)>
                                                {{ $tipo->label() }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('tipo_documento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="numero_documento" class="form-label">Numero de documento:</label>
                                    <input type="number"  step="any"
                                        class="form-control @error('numero_documento') is-invalid @enderror" id="numero_documento"
                                        name="numero_documento" placeholder="Numero de documento"
                                        value="{{ old('numero_documento', $proveedor->numero_documento ?? '') }}">

                                    @error('numero_documento')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="digito_verificacion" class="form-label">Digito de verificación:</label>
                                    <input type="number"  step="any"
                                        class="form-control @error('digito_verificacion') is-invalid @enderror" id="digito_verificacion"
                                        name="digito_verificacion" placeholder="Digito de verificación"
                                        value="{{ old('digito_verificacion', $proveedor->digito_verificacion ?? '') }}">

                                    @error('digito_verificacion')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Campo email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" placeholder="Email del proveedor" name="email"
                                        value="{{ old('email', $proveedor->email ?? '') }}">

                                    <!-- Mensaje de error para Email -->
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label">Telefono:</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                        id="telefono" placeholder="Telefono del proveedor" name="telefono"
                                        value="{{ old('telefono', $proveedor->telefono ?? '') }}">

                                    <!-- Mensaje de error para Telefono -->
                                    @error('telefono')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <!-- Campo direccion -->
                                <div class="col-md-10 mb-3">
                                    <label for="direccion" class="form-label">Direccion:</label>
                                    <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                                        id="direccion" placeholder="Direccion del proveedor" name="direccion"
                                        value="{{ old('direccion', $proveedor->direccion ?? '') }}">

                                    <!-- Mensaje de error para Direccion -->
                                    @error('direccion')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="es_cliente" class="form-label">Es Cliente:</label>
                                    <div class="form-check">
                                        <input class="form-check-input @error('es_cliente') is-invalid @enderror" type="checkbox" id="es_cliente" name="es_cliente" value="1" {{ old('es_cliente', $proveedor->es_cliente ?? '') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="es_cliente">
                                            Sí
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <!-- Botones de Acción -->
                            <a href="{{ route('proveedores.index') }}" class="btn btn-warning">
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
