<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->randomElement([
                'Conseiller en vente',
                'Agent d\'accueil',
                'Agent d\'entretien',
            ]),
            'companies_id'=>company::inRandomOrder()->first()->id,
            'date_debut'=>fake()->date(),
            'address'=>fake()->address(),
            'salaire'=>fake()->numberBetween(1500, 4000),
        ];
    }
}
