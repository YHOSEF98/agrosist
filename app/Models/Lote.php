<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = [
        'nombre',
        'ubicacion',
        'cultivo',
        'variedad',
        'peso_prom',
        'finca_id', // Asegúrate de que este campo exista en tu tabla de lotes
    ];

    // Relación con la finca
    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }
}
