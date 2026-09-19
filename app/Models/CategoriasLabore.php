<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriasLabore extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];
}
