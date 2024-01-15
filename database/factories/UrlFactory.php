<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'realUrl' => $this->faker->realUrl,
            'hashUrl' => $this->faker->hashUrl,
        ];
    }
}
