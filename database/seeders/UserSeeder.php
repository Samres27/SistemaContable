<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'prueba@example.com',
            'password' => Hash::make('password'), // ¡Cambia 'password' por una contraseña segura!
            'created_at' => now(),
            'updated_at' => now(),
            'role' => 'admin'
        ]);
    }
}
