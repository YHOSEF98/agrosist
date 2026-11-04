<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposDocumento extends Model
{
    protected $table = 'tipos_documentos';

    protected $fillable = [
        'nombre',
        'abreviatura',
    ];
}
