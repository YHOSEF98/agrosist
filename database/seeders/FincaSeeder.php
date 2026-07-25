<?php

namespace Database\Seeders;

use App\Models\Finca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FincaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Finca::firstOrCreate([
            'nombre' => 'El Nispero',
            'ubicacion' => 'Santa Teresa',
            'empresa_id' => '1',
        ]);

        Finca::firstOrCreate([
            'nombre' => 'El limon',
            'ubicacion' => 'cienaga el limon',
            'empresa_id' => '2',
        ]);
    }
}
