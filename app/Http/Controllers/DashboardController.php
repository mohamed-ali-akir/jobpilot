<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Company;
use App\Models\Offer;
use Illuminate\Support\Facades\Gate;

/**
 * Contrôleur invocable (séance 4) : php artisan make:controller DashboardController --invokable
 */
class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            ['label' => 'Offres', 'count' => Offer::count(), 'route' => 'offres.index', 'icon' => 'briefcase'],
        ];

        // Entreprises et candidats : seulement pour ceux qui ont accès à ces pages
        if (Gate::allows('gerer-donnees')) {
            $stats[] = ['label' => 'Entreprises', 'count' => Company::count(), 'route' => 'entreprises.index', 'icon' => 'building-office'];
            $stats[] = ['label' => 'Candidats', 'count' => Candidat::count(), 'route' => 'candidats.index', 'icon' => 'users'];
        }

        $latestOffers = Offer::with('company', 'user')->latest()->take(4)->get();

        return view('dashboard', compact('stats', 'latestOffers'));
    }
}
