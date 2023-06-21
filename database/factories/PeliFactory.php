<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PeliFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->randomElement(['El quinto elemento', 'The Cube', 'The Matrix', 'Space Jam', 'Indiana Jones', 'Jurassic Park', 'Terminator', 'Top Gun']),
            'director' => $this->faker->word(),
            'anyo' => $this->faker->numberBetween(1940, 2024),            
            'descatalogada' => $this->faker->boolean
        ];
    }
}
