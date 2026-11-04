<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);

        if ($user) {
            // Crear equipos
            $team1 = Team::create([
                'name' => 'Palmeras del Nispero',
                'slug' => Str::slug('Palmeras del Nispero'),
                'is_personal' => true,
            ]);

            $team2 = Team::create([
                'name' => 'Alberto Meneses',
                'slug' => Str::slug('Alberto Meneses'),
                'is_personal' => false,
            ]);

            // Asignar usuario como miembro de ambos equipos
            DB::table('team_members')->insert([
                'team_id' => $team1->id,
                'user_id' => $user->id,
                'role' => 'owner', // o 'admin', según tu lógica
            ]);

            DB::table('team_members')->insert([
                'team_id' => $team2->id,
                'user_id' => $user->id,
                'role' => 'owner',
            ]);
        }
    }
}
