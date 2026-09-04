@php
    $isEdit = isset($reporte) && $reporte->exists;
    $title = $isEdit ? 'Editar reporte diario' : 'Crear reporte diario';
    $action = $isEdit ? route('reportes-diarios.update', $reporte->id) : route('reportes-diarios.store');

    // Preparamos los trabajadores seleccionados según el contexto
    $trabajadoresSeleccionados = old(
        'trabajadores',
        $isEdit ? $reporte->trabajadores->pluck('id')->toArray() : []
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
                    @livewire('create-reportes-diario',['action' => $action, 'isEdit' => $isEdit,
                     'reporte' => $reporte ?? null, 'labores' => $labores,'lotes' => $lotes, 'acopios' => $acopios])
                </div>
            </div>
        </div>
    </div>
</x-base>
