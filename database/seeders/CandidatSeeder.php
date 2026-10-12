<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\Offer;
use Illuminate\Database\Seeder;

class CandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chaque candidat postule à 1 à 3 offres existantes (relation many-to-many)
        Candidat::factory()->count(6)->create()->each(function (Candidat $candidat) {
            $candidat->offers()->attach(
                Offer::inRandomOrder()->limit(rand(1, 3))->pluck('id')
            );
        });
    }
}
