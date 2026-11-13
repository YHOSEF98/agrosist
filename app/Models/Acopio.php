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

    public function invfrutas()
    {
        return $this->hasMany(InvFruta::class, 'acopio_id');
    }

    public function actualizarEstado(): void
    {
        $ocupado = $this->invfrutas()
            ->whereColumn('cantidad_cargada', '<', 'cantidad')
            ->exists();

        $this->update([
            'estado' => !$ocupado,
        ]);
    }

    protected static function booted(): void
    {
        static::saved(function ($invfruta) {
            $invfruta->acopio?->actualizarEstado();
        });

        static::deleted(function ($invfruta) {
            $invfruta->acopio?->actualizarEstado();
        });
    }
}
