<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViajeFruto extends Model
{
    protected $fillable = [
        'fecha',
        'remision_fruto_id',
        'ticket',
        'ticket_c',
        'peso_bruto',
        'tara',
        'peso_neto',
        'ajuste_calidad',
        'peso_final',
    ];

    public function remisionfruto(){
        return $this->belongsTo(RemisionFruto::class);
    }
}
