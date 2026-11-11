<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleViaje extends Model
{
    protected $fillable = [
        'viaje_fruto_id',
        'det_viaje_fruto_id',
        'promedio',
        'peso_neto',
    ];

    public function viaje_fruto(){
        return $this->belongsTo(ViajeFruto::class, 'viaje_fruto_id');
    }

    public function det_viaje(){
        return $this->belongsTo(DetViajeFruto::class, 'det_viaje_fruto_id');
    }
}
