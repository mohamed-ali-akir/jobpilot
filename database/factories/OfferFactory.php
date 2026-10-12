<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offer>
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
            'name' => fake()->randomElement([
                'Conseiller en vente',
                'Agent d\'accueil',
                'Agent d\'entretien',
                'Développeur web',
                'Technicien support',
                'Préparateur de commandes',
            ]),
            // Réutilise une entreprise existante, sinon en crée une
            'company_id' => Company::inRandomOrder()->value('id') ?? Company::factory(),
            'type_contrat' => fake()->randomElement(Offer::TYPES_CONTRAT),
            'date_debut' => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'address' => fake()->randomElement(['Paris', 'Lyon', 'Marseille', 'Lille', 'Bordeaux', 'Nantes', 'Toulouse', 'Dijon']),
            'salaire' => fake()->numberBetween(1500, 4000),
        ];
    }
}
