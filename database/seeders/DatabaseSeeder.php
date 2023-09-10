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
        // User::create([
        //     'foto' => 'admin.jpg',
        //     'nik' => '123456',
        //     'nama' => 'Admin',
        //     'username' => 'admin',
        //     'password' => Hash::make('password'),
        //     'email' => "admin@gmail.com",
        //     'no_telp' => '123456789',
        //     'role' => 'admin',
        //     'status' => "aktif"
        // ]);
        // \App\Models\User::factory(10)->create();
        // \App\Models\Sekolah::factory(1)->create();
        // \App\Models\Siswa::factory(35)->create();
        \App\Models\Mapel::factory(10)->create();
    }
}
