<?php

namespace App\Livewire;
use App\Models\Trabajador;
use Livewire\Attributes\On;

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
        $this->fecha = $fecha;
    }

    public function mount($fechaInicial = null, $trabajadoresIniciales = [])
    {
        $this->fecha = $fechaInicial;
        $this->trabajadores = $trabajadoresIniciales;
    }

    public function getTrabajadoresDisponiblesProperty()
    {
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
