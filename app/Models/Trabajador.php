<?php

namespace App\Models;
use App\Models\TiposDocumento;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';
    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento_id',
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
        'team_id', // Add this line to allow mass assignment for aux_transporte
    ];
    protected function nombres(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_convert_case(trim($value), MB_CASE_TITLE, 'UTF-8')
        );
    }

    protected function apellidos(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_convert_case(trim($value), MB_CASE_TITLE, 'UTF-8')
        );
    }

    public function scopeActivos($query)
    {
        return $query->where('estatus', 'activo');
    }

    // Relación con la empresa
    public function Team()
    {
        return $this->belongsTo(Team::class);
    }
    public function tipo_documento()
    {
        return $this->belongsTo(TiposDocumento::class);
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function cuadrillas()
    {
        return $this->belongsToMany(Cuadrilla::class, 'cuadrilla_trabajador')
                    ->withPivot('fecha')
                    ->withTimestamps();
    }
}
