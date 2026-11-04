<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Yhosef Mayorga',
            'email' => 'mayorgalive@hotmail.com',
            'password' => Hash::make('1065245907Mc-'),
        ]);
        User::firstOrCreate([
            'name' => 'Yhosef Nicolas Mayorga',
            'email' => 'sololausareaqui@gmail.com',
            'password' => Hash::make('1065245907Mc-'),
        ]);
    }
}
