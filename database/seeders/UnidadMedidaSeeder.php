<?php

namespace Database\Seeders;

use App\Models\UnidadMedida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnidadMedida::firstOrCreate([
            'nombre'=>'Tonelada',
            'abrev'=>'Ton',
        ]);
        UnidadMedida::firstOrCreate([
            'nombre'=>'Metro',
            'abrev'=>'M',
        ]);
        UnidadMedida::firstOrCreate([
            'nombre'=>'Palma',
            'abrev'=>'Plm',
        ]);
        UnidadMedida::firstOrCreate([
            'nombre'=>'Hectarea',
            'abrev'=>'Hec',
        ]);
        UnidadMedida::firstOrCreate([
            'nombre'=>'Jornal',
            'abrev'=>'Jor',
        ]);
    }
}
