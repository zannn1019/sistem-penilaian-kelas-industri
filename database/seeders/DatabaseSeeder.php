<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('nik', '1')->count() == 0) {
            $defaultImagePath = public_path('img/user.png'); // Update this path to the actual location of your default image
            $destinationPath = 'public/pengajar/user.png'; // Update this path to the desired storage path

            if (!Storage::disk('public')->exists($destinationPath)) {
                // Make sure the directory structure exists before copying
                Storage::disk('public')->makeDirectory('public/pengajar');

                // Copy the default image to the storage
                Storage::disk('public')->copy($defaultImagePath, $destinationPath);
            }

            User::create([
                'foto' => $destinationPath,
                'nik' => '1',
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'email' => 'admin@gmail.com',
                'no_telp' => '123456789',
                'role' => 'admin',
                'status' => 'aktif'
            ]);
        }
    }
}
