<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acopio extends Model
{
    protected $fillable = [
        'nombre',
        'estado',
        'finca_id',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }
}
