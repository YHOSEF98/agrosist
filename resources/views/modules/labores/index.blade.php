<x-base title="Labores">
    <div class="row">
        <div class="app-content" bis_skin_checked="1">
            <div class="container-fluid" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-header" bis_skin_checked="1">
                        <h3 class="card-title">Listado de labores</h3>
                        <div class="card-tools" bis_skin_checked="1">
                            <div class="input-group input-group-sm" style="width: 16rem" bis_skin_checked="1">
                                <span class="input-group-text">
                                    <i class="bi bi-search" aria-hidden="true"></i>
                                </span>
                                <input id="table-filter" type="search" class="form-control" placeholder="Filter rows…"
                                    aria-label="Filter rows">
                            </div>
                        </div>
                    </div>
                    <div class="card-body" bis_skin_checked="1">
                        <div class="d-flex gap-2 mb-3" bis_skin_checked="1">
                            <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                                Export CSV
                            </button>
                            <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-filetype-json me-1" aria-hidden="true"></i>
                                Export JSON
                            </button>
                            <button id="print-table" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-printer me-1" aria-hidden="true"></i>
                                Print
                            </button>
                            <a href="{{ route('labores.create') }}" id="print-table" type="button"
                                class="btn btn-sm btn-outline-success">
                                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
                                Crear Labor
                            </a>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Actividad</th>
                                    <th scope="col">Um</th>
                                    <th scope="col">Rendimiento</th>
                                    <th scope="col">Valor unitario</th>
                                    <th scope="col">Tarifa directo</th>
                                    <th scope="col">Tarifa contratista</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($labores as $labor)
                                    <tr>
                                        <th scope="row">{{ $labor->id }}</th>
                                        <td>{{ $labor->actividad }}</td>
                                        <td><code>{{ $labor->unidad_medida?->abrev }}</code></td>
                                        <td><code>{{ $labor->rendimiento_esperado }}</code></td>
                                        <td><code>{{ $labor->valor_unitario }}</code></td>
                                        <td><code>{{ $labor->tarifa_personal_directo }}</code></td>
                                        <td><code>{{ $labor->tarifa_contratista }}</code></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- Botón de Ver (Ojo) -->
                                                <button type="button" class="btn btn-sm btn-outline-warning"
                                                    title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <!-- Botón de Editar (Lápiz) -->
                                                <a href="{{ route('labores.edit',  $labor->id) }}" type="button"
                                                    class="btn btn-sm btn-outline-secondary" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <!-- Botón de Eliminar (Basura) -->
                                                <form action="{{ route('labores.destroy', $labor->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('¿Estás completamente seguro de eliminar la actividad «{{ $labor->actividad }}»? Esta acción no se puede deshacer.');">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Este bloque se activa automáticamente si no hay empresas en la base de datos -->
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="bi bi-info-circle me-1"></i> No hay datos creados actualmente
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-secondary small" bis_skin_checked="1">
                        Powered by
                        <a href="#" target="_blank" rel="noopener">Dashboard</a>
                    </div>
</x-base>