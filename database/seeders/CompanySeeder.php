<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Bricoman', 'Leroy Merlin', 'Amazon', 'Boulanger'] as $nom) {
            Company::create(['nom' => $nom]);
        }
    }
}
