<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemisionFruto extends Model
{
    protected $fillable = [
        'team_id',
        'fecha',
        'remision',
        'finca_id',
        'destino_id',
        'provedore_id',
        'conductore_id',
        'placa',
        'firma_conductor',
        'autorizado_por',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    public function destino()
    {
        return $this->belongsTo(Provedore::class, 'destino_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Provedore::class, 'provedore_id');
    }

    public function conductor()
    {
        return $this->belongsTo(Conductore::class, 'conductore_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetViajeFruto::class, 'remision_fruto_id');
    }

    public function viajefruto(){
        return $this->hasOne(ViajeFruto::class);
    }


}
