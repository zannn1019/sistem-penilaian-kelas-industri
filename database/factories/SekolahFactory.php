<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sekolah>
 */
class SekolahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'logo' =>  fake()->numberBetween(1, 5) . ".png",
            'nama' => "SMKN " . fake()->numberBetween(1, 10) . " " . fake()->city(),
            'provinsi' => fake()->state,
            'kabupaten_kota' => fake()->city(),
            'kecamatan' => fake()->city(),
            'kelurahan' => fake()->citySuffix(),
            'jalan' => fake()->streetAddress(),
            'email' => fake()->email(),
            'no_telp' => fake()->phoneNumber()
        ];
    }
}
