<?php

namespace Database\Seeders;
use App\Models\Candidat;
use Database\factories\CandidatFactory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Candidat::factory()->count(5)->create();
    }
}
