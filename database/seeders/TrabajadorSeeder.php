<?php

namespace Database\Seeders;

use App\Models\Trabajador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trabajador::firstOrCreate([
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'tipo_documento' => 'CC',
            'numero_documento' => '12345678',
            'fecha_ingreso' => now(),
            'email' => 'juan.perez@example.com',
            'fecha_nacimiento' => '1990-01-01',
            'telefono' => '123456789',
            'direccion' => 'Calle Principal 123',
            'persona_contacto' => 'María García',
            'telefono_persona_contacto' => '987654321',
            'cargo_id' => '1',
            'salario' => '1000.00',
            'aux_transporte' => '200.00',
            'empresa_id' => '1',
            'estatus' => 'activo',
        ]);
        Trabajador::firstOrCreate([
            'nombres' => 'yhosef',
            'apellidos' => 'Perez',
            'tipo_documento' => 'CC',
            'numero_documento' => '123456789',
            'fecha_ingreso' => now(),
            'email' => 'yhosef.perez@example.com',
            'fecha_nacimiento' => '1990-01-01',
            'telefono' => '123456789',
            'direccion' => 'Calle Principal 123',
            'persona_contacto' => 'María García',
            'telefono_persona_contacto' => '987654321',
            'cargo_id' => '1',
            'salario' => '1000.00',
            'aux_transporte' => '200.00',
            'empresa_id' => '1',
            'estatus' => 'activo',
        ]);

    }
}
