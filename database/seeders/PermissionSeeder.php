<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            'ver_roles',
            'crear_roles',
            'editar_roles',
            'eliminar_roles',
            'ver_empresas',
            'crear_empresas',
            'editar_empresas',
            'eliminar_empresas',
            'ver_usuarios',
            'crear_usuarios',
            'editar_usuarios',
            'eliminar_usuarios',
            'ver_fincas',
            'editar_fincas',
            'eliminar_fincas',
            'crear_team',
            'editar_team',
            'eliminar_team',
            'ver_lote',
            'crear_lote',
            'editar_lote',
            'eliminar_lote',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }
    }
}
