<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'SuperAdmin',
            'Auxiliar',
            'Supervisor Cosecha',
            'Trabajador',
        ];

        foreach ($roles as $rol) {
            Role::create([
                'name' => $rol,
                'guard_name' => 'web', // 👈 obligatorio
            ]);
        }
    }
}
