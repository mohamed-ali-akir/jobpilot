<?php

namespace Database\Seeders;

use App\Models\Offer;
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
        // Comptes de test (mot de passe : password)
        User::factory()->admin()->create([
            'name' => 'Alice Admin',
            'email' => 'admin@jobpilot.test',
        ]);

        $editeur = User::factory()->editeur()->create([
            'name' => 'Eddy Éditeur',
            'email' => 'editeur@jobpilot.test',
        ]);

        User::factory()->editeur()->create([
            'name' => 'Emma Éditrice',
            'email' => 'editrice@jobpilot.test',
        ]);

        User::factory()->create([
            'name' => 'Victor Visiteur',
            'email' => 'visiteur@jobpilot.test',
        ]);

        // Ordre important : utilisateurs -> entreprises -> offres -> candidats
        $this->call([
            CompanySeeder::class,
            OfferSeeder::class,
            CandidatSeeder::class,
        ]);

        // Les offres qui n'ont pas d'auteur sont attribuées à l'éditeur principal
        Offer::whereNull('user_id')->update(['user_id' => $editeur->id]);
    }
}
