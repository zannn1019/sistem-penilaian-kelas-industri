<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'foto' => '11.jpeg',
            'nik' => fake()->nik(),
            'nama' => fake()->name(),
            'username' => fake()->userName(),
            'password' => Hash::make(fake()->password()),
            'email' => fake()->email(),
            'no_telp' => fake()->phoneNumber(),
            'role' => 'pengajar',
            'status' => collect(['aktif', 'nonaktif'])->random(1)->first()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
