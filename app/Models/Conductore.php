<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TipoDocumento;

class Conductore extends Model
{
    protected $table = 'conductores';

    protected $casts = [
        'tipo_documento' => TipoDocumento::class,
    ];

    protected $fillable = [
        'provedore_id',
        'tipo_documento_id',
        'numero_documento',
        'nombres',
        'apellidos',
        'placa',
        'telefono',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Provedore::class, 'provedore_id');
    }
}
