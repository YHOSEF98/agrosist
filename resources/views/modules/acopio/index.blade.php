<x-base title="Acopios">
    <div class="row">
        <div class="app-content" bis_skin_checked="1">
            <div class="container-fluid" bis_skin_checked="1">
                <div class="card" bis_skin_checked="1">
                    <div class="card-header" bis_skin_checked="1">
                        <h3 class="card-title">Listado de acopios</h3>
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
                            <a href="{{ route('acopio-create') }}" id="print-table" type="button"
                                class="btn btn-sm btn-outline-success">
                                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
                                Crear acopio
                            </a>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Finca</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($acopios as $acopio)
                                    <tr>
                                        <th scope="row">{{ $acopio->id }}</th>
                                        <td>{{ $acopio->nombre }}</td>
                                        <td>
                                            @if ($acopio->estado)
                                                <span class="badge rounded-pill text-bg-info">Libre</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-warning">Ocupado</span>
                                            @endif
                                        </td>
                                        <td>{{ $acopio->finca->nombre }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- Botón de Ver (Ojo) -->
                                                <button type="button" class="btn btn-sm btn-outline-warning"
                                                    title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <!-- Botón de Editar (Lápiz) -->
                                                <a href="{{ route('acopio-edit', $acopio->id) }}" type="button"
                                                    class="btn btn-sm btn-outline-secondary" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <!-- Botón de Eliminar (Basura) -->
                                                <form action="{{ route('acopio-destroy', $acopio->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf

                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('¿Estás completamente seguro de eliminar el acopio «»? Esta acción no se puede deshacer.');">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Este bloque se activa automáticamente si no hay empresas en la base de datos -->
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
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
