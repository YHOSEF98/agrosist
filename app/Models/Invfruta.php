<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invfruta extends Model
{
    protected $fillable = [
        'fecha',
        'lote_id',
        'reporte_id',
        'acopio_id',
        'cantidad',
        'cargado'
    ];

    public function detalles()
    {
        return $this->hasMany(DetViajeFruto::class, 'invfrutas_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function acopio()
    {
        return $this->belongsTo(Acopio::class);
    }
}