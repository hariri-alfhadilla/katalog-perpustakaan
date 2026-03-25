<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Bikin Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => Hash::make('password1'), // Passwordnya: password
            'role' => 'admin',
        ]);

        // Bikin Akun Siswa
        User::create([
            'name' => 'Siswa Teladan',
            'email' => 'siswa@test.com',
            'password' => Hash::make('password1'), // Passwordnya: password
            'role' => 'user',
        ]);
    }
}