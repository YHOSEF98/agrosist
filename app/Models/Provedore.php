<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TipoDocumento;

class Provedore extends Model
{
    protected $table = 'provedores';

    protected $casts = [
        'es_cliente' => 'boolean',
        'tipo_documento' => TipoDocumento::class,
    ];

     protected $fillable = [
        'razon_social',
        'nombre_comercial',
        'tipo_contribuyente',
        'tipo_documento',
        'numero_documento',
        'digito_verificador',
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
