<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin PPM',
            'email' => 'admin@ppm.com',
            'password' => Hash::make('password123'),
            'role' => 'ppm'
        ]);
        User::create([
            'name' => 'Kaprodi',
            'email' => 'kaprodi@prodi.com',
            'password' => Hash::make('password123'),
            'role' => 'kaprodi'
        ]);
        User::create([
            'name' => 'Ketua Pelaksana',
            'email' => 'ketua@litmas.com',
            'password' => Hash::make('password123'),
            'role' => 'ketua_pelaksana'
        ]);
    }
}
