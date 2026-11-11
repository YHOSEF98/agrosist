<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetViajeFruto extends Model
{
    protected $fillable = [
        'remision_fruto_id',
        'invfrutas_id',
        'cantidad_cargada',
    ];

    public function remision()
    {
        return $this->belongsTo(RemisionFruto::class, 'remision_fruto_id');
    }

    public function invfruta()
    {
        return $this->belongsTo(Invfruta::class, 'invfrutas_id');
    }

    public function detalleViaje()
    {
        return $this->hasOne(DetalleViaje::class, 'det_viaje_fruto_id');
    }
}
