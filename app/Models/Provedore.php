<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provedore extends Model
{
    protected $table = 'provedores';

    protected $casts = [
        'es_cliente' => 'boolean',
    ];

     protected $fillable = [
        'razon_social',
        'nombre_comercial',
        'tipo_documento_id',
        'numero_documento',
        'digito_verificacion',
        'direccion',
        'telefono',
        'email',
        'es_cliente'
    ];

    public function conductores()
    {
        return $this->hasMany(Conductore::class);
    }
}
