<?php

namespace Database\Factories;

use App\Models\candidat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<candidat>
 */
class CandidatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname'=>fake()->firstname(),
            'lastname'=>fake()->lastname(),
        ];
    }
}
