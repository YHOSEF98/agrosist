<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cargo::firstOrCreate(['nombre' => 'Administrador']);
        Cargo::firstOrCreate(['nombre' => 'Operario']);
        Cargo::firstOrCreate(['nombre' => 'Supervisor']);
        Cargo::firstOrCreate(['nombre' => 'Gerente']);
        Cargo::firstOrCreate(['nombre' => 'Contador']);
        Cargo::firstOrCreate(['nombre' => 'Ingeniero Agrónomo']);
        Cargo::firstOrCreate(['nombre' => 'Técnico de Campo']);
        Cargo::firstOrCreate(['nombre' => 'Asistente Administrativo']);
        Cargo::firstOrCreate(['nombre' => 'Jefe de Producción']);
        Cargo::firstOrCreate(['nombre' => 'Encargado de Logística']);
    }
}
