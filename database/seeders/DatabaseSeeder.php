<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CandidatSeeder;
use Database\Seeders\companySeeder;
use Database\Seeders\OfferSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $companies = [
            'Bricoman',
            'Leroy Merlin',
            'Amazon',
            'Boulanger',
        ];
        
        foreach ($companies as $company) {
            Company::factory()->create([
                'nom' => $company,
            ]);
        }

        $this->call([
            CandidatSeeder::class,
            OfferSeeder::class,
        ]);

        

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
