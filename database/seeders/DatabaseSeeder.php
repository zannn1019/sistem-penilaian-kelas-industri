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
        // User::create([
        //     'foto' => '11.jpeg',
        //     'nik' => fake()->nik(),
        //     'nama' => fake()->name(),
        //     'username' => fake()->userName(),
        //     'password' => Hash::make(fake()->password()),
        //     'email' => fake()->email(),
        //     'no_telp' => fake()->phoneNumber(),
        //     'role' => 'pengajar',
        //     'status' => collect(['aktif', 'nonaktif'])->random(1)->first()
        // ]);
        // \App\Models\Sekolah::factory(1)->create();
    }
}
