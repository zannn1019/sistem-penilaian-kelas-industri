<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_sekolah' => Sekolah::all()->random(1)->first()->id,
            'id_kelas' => Kelas::all()->random(1)->first()->id,
            'nis' => fake()->nik(),
            'nama' => fake()->name(),
            'no_telp' => fake()->phoneNumber(),
            'tahun_ajar' => date('Y') . '/' . date('Y') + 1,
            'semester' => 'ganjil'
        ];
    }
}
