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
        if (User::where('nik', '1')->count() == 0) {
            User::create([
                'foto' => 'admin.jpg',
                'nik' => '1',
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'email' => "admin@gmail.com",
                'no_telp' => '123456789',
                'role' => 'admin',
                'status' => "aktif"
            ]);
        }
        if (User::where('nik', '2')->count() == 0) {
            User::create([
                'foto' => 'ahmad-fauza.jpg',
                'nik' => '2',
                'nama' => 'Pengajar',
                'username' => 'pengajar',
                'password' => Hash::make('password'),
                'email' => "pengajar@gmail.com",
                'no_telp' => '123456789',
                'role' => 'pengajar',
                'status' => "aktif"
            ]);
        }
        // \App\Models\User::factory(10)->create();
        \App\Models\Sekolah::factory(1)->create();
        \App\Models\Kelas::factory(1)->create();
        \App\Models\Siswa::factory(1)->create();
        \App\Models\Mapel::factory(1)->create();
    }
}
