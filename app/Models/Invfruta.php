<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}