<?php

namespace Database\Seeders;

use App\Models\Lote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lote::firstOrCreate([
            'nombre' => 'Lote 1',
            'ubicacion' => 'Santa Teresa',
            'cultivo' => 'Palma de aceite',
            'variedad' => 'Damia',
            'peso_prom' => '2.1',
            'finca_id' => '1',
        ]);
        Lote::firstOrCreate([
            'nombre' => 'Lote 2',
            'ubicacion' => 'Santa Teresa',
            'cultivo' => 'Palma de aceite',
            'variedad' => 'Damia',
            'peso_prom' => '2.1',
            'finca_id' => '1',
        ]);

        }
}
