<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\companyFactory;
use App\Models\company;

class companySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        company::factory()->count(5)->create();
    }
}
