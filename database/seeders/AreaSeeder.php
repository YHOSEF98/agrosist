<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::firstOrCreate(['nombre' => 'Mantenimiento', 'descripcion' => 'Área encargada del mantenimiento de las instalaciones y equipos.', 'estado' => true]);
        Area::firstOrCreate(['nombre' => 'Sanidad', 'descripcion' => 'Área encargada de la sanidad del cultivo', 'estado' => true]);
        Area::firstOrCreate(['nombre' => 'Cosecha', 'descripcion' => 'Área encargada del mantenimiento de la cosecha.', 'estado' => true]);
    }
}
