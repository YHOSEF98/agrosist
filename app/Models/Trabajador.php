<?php

namespace App\Models;
use App\Enums\TipoDocumento;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';
    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'fecha_ingreso',
        'email',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'persona_contacto',
        'telefono_persona_contacto',
        'cargo_id',
        'salario',
        'aux_transporte',
        'estatus',
        'empresa_id', // Add this line to allow mass assignment for aux_transporte
    ];
    protected $casts = [
        'tipo_documento' => TipoDocumento::class,
    ];

    public function scopeActivos($query)
    {
        return $query->where('estatus', 'activo');
    }

    // Relación con la empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function cuadrillas()
    {
        return $this->belongsToMany(Cuadrilla::class, 'cuadrilla_trabajador')
                    ->withPivot('fecha')
                    ->withTimestamps();
    }
}
