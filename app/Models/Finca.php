<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finca extends Model
{
    protected $fillable = [
        'nombre',
        'ubicacion',
        'team_id', // Relación con la empresa
    ];

    // Relación con la empresa
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
