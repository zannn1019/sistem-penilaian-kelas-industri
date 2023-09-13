<?php

namespace Database\Factories;

use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
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
            'nama_kelas' => "Kelas " . fake()->jobTitle,
            'tingkat' => collect(['10', '11', '12', '13'])->random(1)->first(),
            'jurusan' => fake()->jobTitle(),
            'kelas' => fake()->regexify('[A-Za-z0-9]{1}'),
            'created_at' => date(now()),
            'updated_at' => date(now())
        ];
    }
}
