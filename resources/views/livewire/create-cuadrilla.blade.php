<div class="card mb-4">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Trabajadores asignados a la cuadrilla</h3>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTrabajador">
                        <i class="bi bi-plus"></i> Añadir trabajador
                    </button>
                </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table table-striped" role="table">
                      <thead>
                        <tr>
                          <th style="width: 10px" scope="col">#</th>
                          <th scope="col">Nombres</th>
                          <th scope="col">Apellidos</th>
                          <th style="width: 40px" scope="col">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ( $trabajadores as $trabajador )
                        <tr class="align-middle">
                            <th scope="row">{{ $trabajador['id'] }}</th>
                            <td>{{ $trabajador['nombres'] }}</td>
                            <td>{{ $trabajador['apellidos'] }}</td>
                            <td>
                                <div class="btn-group" role="group">

                                    <!-- Botón de Eliminar -->
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar" wire:click="eliminartrabajador({{ $trabajador['id'] }})"   >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                            <input type="hidden" name="trabajadores[{{ $trabajador['id'] }}][id]" value="{{ $trabajador['id'] }}">
                        </tr>
                         @empty
                                    <!-- Este bloque se activa automáticamente si no hay Trabajadores en la base de datos -->
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="bi bi-info-circle me-1"></i> No hay trabajadores asignados actualmente
                                        </td>
                                    </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <!-- Modal -->
                <div wire:ignore.self class="modal fade" id="modalTrabajador" tabindex="-1" aria-labelledby="modalTrabajadorLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTrabajadorLabel">Seleccionar trabajador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        <label for="trabajador_id" class="form-label">Trabajador disponible</label>
                        <select id="trabajador_id" class="form-select" wire:model="trabajadorSeleccionado">
                            <option value="">Seleccione...</option>
                            @foreach($trabajadoresDisponibles as $trabajador)
                                <option value="{{ $trabajador->id }}">
                                    {{ $trabajador->nombres }} {{ $trabajador->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" wire:click="agregarTrabajador" data-bs-dismiss="modal">
                        Añadir
                        </button>
                    </div>
                    </div>
                </div>
                </div>
</div>
