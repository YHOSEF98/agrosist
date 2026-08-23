<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pluviometro extends Model
{
    protected $fillable = [
        'finca_id',
        'nombre',
        'ubicacion',
        'observaciones',
    ];

    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    public function pluviometria()
    {
        return $this->hasMany(Pluviometria::class);
    }
}
