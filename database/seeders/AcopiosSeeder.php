<?php

namespace Database\Seeders;

use App\Models\Acopio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcopiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Acopio::firstOrCreate([
            'nombre' => 'Gondola 1',
            'estado' => 1,
            'finca_id' => '1',
        ]);
    }
}
