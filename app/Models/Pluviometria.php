<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pluviometria extends Model
{
    protected $fillable = [
        'pluviometro_id',
        'fecha',
        'cantidad',
    ];

    public function pluviometro()
    {
        return $this->belongsTo(Pluviometro::class);
    }
}
