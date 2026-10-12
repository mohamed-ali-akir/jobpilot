<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Company;
use App\Models\Offer;

/**
 * Contrôleur invocable (séance 4) : php artisan make:controller DashboardController --invokable
 */
class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            ['label' => 'Offres', 'count' => Offer::count(), 'route' => 'offres.index', 'icon' => 'briefcase'],
            ['label' => 'Entreprises', 'count' => Company::count(), 'route' => 'entreprises.index', 'icon' => 'building-office'],
            ['label' => 'Candidats', 'count' => Candidat::count(), 'route' => 'candidats.index', 'icon' => 'users'],
        ];

        $latestOffers = Offer::with('company')->latest()->take(4)->get();

        return view('dashboard', compact('stats', 'latestOffers'));
    }
}
