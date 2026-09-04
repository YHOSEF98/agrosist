<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetReportesDiario extends Model
{
    protected $fillable = [
        'reporte_diario_id',
        'acopios_id',
        'lote_id',
        'lineas',
        'cantidad',
    ];

    public function reporteDiario()
    {
        return $this->belongsTo(ReportesDiario::class, 'reporte_diario_id');
    }

    public function acopio()
    {
        return $this->belongsTo(Acopio::class, 'acopios_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}
