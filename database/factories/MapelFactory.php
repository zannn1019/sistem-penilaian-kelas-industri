<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mapel>
 */
class MapelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'nama_mapel' => fake()->randomElement([
                'PHP',
                'JavaScript',
                'Python',
                'Java',
                'C#',
                'Ruby',
                'Swift',
                'Go',
                'Rust',
                'Kotlin',
                'TypeScript',
                'Perl',
                'Scala',
                'Haskell',
                'Lua',
                'Dart',
                'Elixir',
                'Clojure',
                'Objective-C',
                'F#',
                'R',
                'COBOL',
                'Assembly',
                'VHDL',
                'PL/SQL',
                'Groovy',
                'Julia',
                'Scheme',
                'Fortran',
            ])

        ];
    }
}
