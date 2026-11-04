<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::firstOrCreate([
            'team_id' => 1,
            'razon_social' => 'Palmeras del Nispero S.A.S',
            'nombre_comercial' => 'Palmeras del Nispero',
            'tipo_documento_id' => 3,
            'numero_documento' => '901630793',
            'digito_verificacion' => 3,
            'direccion' => 'Calle 2 #54-54, La gloria',
            'telefono' => '3103250719',
            'email' => 'palmerasdelnispero@gmail.com',
        ]);

        Empresa::firstOrCreate([
            'team_id' => 2,
            'razon_social' => 'Alberto Meneses Romero',
            'nombre_comercial' => 'Alberto Meneses Romero',
            'tipo_documento_id' => 1,
            'numero_documento' => '5044355',
            'digito_verificacion' => 0,
            'direccion' => 'Calle 1 #1-1, Ciudad',
            'telefono' => '3103250719',
            'email' => 'albertomeneses@gmail.com',
        ]);
    }
}
