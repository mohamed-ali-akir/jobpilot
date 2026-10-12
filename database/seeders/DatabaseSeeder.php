<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ordre important : entreprises -> offres -> candidats (qui postulent aux offres)
        $this->call([
            CompanySeeder::class,
            OfferSeeder::class,
            CandidatSeeder::class,
        ]);

        // Compte de test (mot de passe : password)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
