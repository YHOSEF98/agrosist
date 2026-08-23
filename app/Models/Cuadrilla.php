<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuadrilla extends Model
{
    protected $fillable = [
        'fecha',
        'nombre',
        'labore_id',
        'observacion',
    ];
    public function labor()
    {
        return $this->belongsTo(Labore::class, 'labore_id');
    }
    
    public function trabajadores()
    {
        return $this->belongsToMany(Trabajador::class, 'cuadrilla_trabajador')
                    ->withPivot('fecha')
                    ->withTimestamps();
    }
}
