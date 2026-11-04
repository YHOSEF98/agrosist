<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Labore;

class LaboresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Labore::create([
            'actividad' => 'Alce de fruto',
            'unidad_medida_id' => 1,
            'rendimiento_esperado' => 100,
            'valor_unitario' => 10.00,
            'tarifa_contratista' => 15.00,
            'tarifa_personal_directo' => 20.00,
            'valor_prestaciones' => 25.00,
            'valor_total' => 30.00,
            'observaciones' => 'Observaciones de prueba',
            'invfruta' => true,
        ]);

    }
}
