<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Word>
 */
class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'term' => $this->faker->word(),
            'positive_count' => $this->faker->randomNumber(),
            'negative_count' => $this->faker->randomNumber(),
            'source' => \App\Models\Word::SOURCE_GITHUB
        ];
    }
}
