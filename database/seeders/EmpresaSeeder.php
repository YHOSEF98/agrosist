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
            'nit' => '901630793',
            'nombre' => 'Palmeras del Nispero',
        ]);

        Empresa::firstOrCreate([
            'nit' => '5044355',
            'nombre' => 'Alberto Meneses Romero',
        ]);
    }
}
