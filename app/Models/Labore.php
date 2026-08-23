<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

class Labore extends Model
{
    protected $fillable = [
        'actividad',
        'unidad_medida_id',
        'rendimiento_esperado',
        'valor_unitario',
        'tarifa_contratista',
        'tarifa_personal_directo',
        'valor_prestaciones',
        'valor_total',
        'observaciones',
    ];

    // Relación con la Unidades de medida
    public function unidad_medida()
    {
        return $this->belongsTo(UnidadMedida::class);
    }
}
