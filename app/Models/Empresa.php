<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TipoDocumento;
use App\Enums\TipoContribuyente;

class Empresa extends Model
{
        protected $fillable = [
            'team_id',
            'razon_social',
            'nombre_comercial',
            'tipo_documento_id',
            'numero_documento',
            'digito_verificador',
            'direccion',
            'telefono',
            'email',
    ];
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
