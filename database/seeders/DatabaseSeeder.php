<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'foto' => 'admin.jpg',
            'nik' => '123456',
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('password'), // Ganti dengan password yang Anda inginkan
            'no_telp' => '123456789',
            'role' => 'admin',
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
