<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_documentos')->insert([
            ['nombre' => 'Cédula de ciudadanía', 'abreviatura' => 'CC'],
            ['nombre' => 'Cédula de extranjería', 'abreviatura' => 'CE'],
            ['nombre' => 'NIT', 'abreviatura' => 'NIT'],
            ['nombre' => 'Pasaporte', 'abreviatura' => 'PA'],
            ['nombre' => 'Tarjeta de identidad', 'abreviatura' => 'TI'],
        ]);
    }
}
