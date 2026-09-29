<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Admin Parkir',
            'email' => 'admin@email.com',
            'password' => bcrypt('password123'),
            'peran' => 'admin', 
        ]);

        // 2. Akun Petugas
        User::create([
            'name' => 'Petugas Parkir',
            'email' => 'petugas@email.com',
            'password' => bcrypt('password123'),
            'peran' => 'Operator Lapangan', // Disesuaikan dengan nilai default sistemmu
        ]);

        // 3. Akun Owner
        User::create([
            'name' => 'Owner Parkir',
            'email' => 'owner@email.com',
            'password' => bcrypt('password123'),
            'peran' => 'owner', 
        ]);
    }
}
