<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportesDiario extends Model
{
    protected $fillable = [
        'fecha',
        'cuadrilla_id',
        'labore_id',
        'observacion',
    ];

    public function cuadrilla()
    {
        return $this->belongsTo(Cuadrilla::class, 'cuadrilla_id');
    }
    public function labores()
    {
        return $this->belongsTo(Labore::class, 'labore_id');
    }
}
