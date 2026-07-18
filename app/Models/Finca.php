<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finca extends Model
{
    protected $fillable = [
        'nombre',
        'ubicacion',
        'empresa_id', // Relación con la empresa
    ];

    // Relación con la empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
