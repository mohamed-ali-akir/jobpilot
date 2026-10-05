<?php

namespace Database\Factories;

use App\Models\company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<company>
 */
class companyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom'=>fake()->RandomElement([
                'Bricoman',
                'Leroymerlin',
                'Amazon',
                'Boulanger',
            ])
        ];
    }
}
