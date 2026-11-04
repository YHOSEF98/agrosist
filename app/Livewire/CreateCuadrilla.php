<?php

namespace App\Livewire;
use App\Models\Trabajador;
use Livewire\Attributes\On;
use Flux\Flux;

use Livewire\Component;

class CreateCuadrilla extends Component
{
    public $trabajadores = []; // seleccionados
    public $fecha; // fecha de la cuadrilla
    public $trabajadorSeleccionado;
    public $trabajadoresIniciales = [];

    #[On('fechaActualizada')]
    public function actualizarFecha($fecha)
    {
       // Comprobar si realmente cambió la fecha
        if ($this->fecha !== $fecha) {

            // Actualizar la fecha
            $this->fecha = $fecha;

            // Eliminar todos los trabajadores seleccionados
            $this->trabajadores = [];

            // Limpiar cualquier selección pendiente
            $this->trabajadorSeleccionado = null;
        }
    }

    public function mount($fechaInicial = null, $trabajadoresIniciales = [])
    {
        $this->fecha = $fechaInicial;
        $this->trabajadores = $trabajadoresIniciales;
    }

    public function getTrabajadoresDisponiblesProperty()
    {
        // Si no hay fecha seleccionada, no mostrar trabajadores.
        if (empty($this->fecha)) {
            return collect();
        }

        $idsSeleccionados = collect($this->trabajadores)
            ->pluck('id')
            ->toArray();

        return Trabajador::query()
        ->when($this->fecha, function ($q) {
            $q->whereDoesntHave('cuadrillas', function ($sub) {
                $sub->whereDate('cuadrillas.fecha', $this->fecha);
            });
        })
        ->whereNotIn('trabajadores.id', $idsSeleccionados)
        ->get();
    }

    public function agregarTrabajador()
    {
        if ($this->trabajadorSeleccionado) {
            $trabajador = Trabajador::find($this->trabajadorSeleccionado);

            $this->trabajadores[] = [
                'id' => $trabajador->id,
                'nombres' => $trabajador->nombres,
                'apellidos' => $trabajador->apellidos,
            ];

            $this->trabajadorSeleccionado = null;
            Flux::modal('modal-trabajador')->close();
        }
    }

    public function eliminartrabajador($id)
    {
        $this->trabajadores = array_filter($this->trabajadores, function ($trabajador) use ($id) {
            return $trabajador['id'] != $id;
        });
        $this->trabajadores = array_values($this->trabajadores); // Reindexar el array
    }

    public function render()
    {
        return view('livewire.create-cuadrilla', [
            'trabajadores' => $this->trabajadores,
            'trabajadoresDisponibles' => $this->trabajadoresDisponibles,
        ]);
    }
}
