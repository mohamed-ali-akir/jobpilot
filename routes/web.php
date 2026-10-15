<?php

use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Offres : la protection est dans OfferController (#[Middleware] et #[Authorize]).
// Liste et détail visibles par tout le monde, même un invité.
// « Mes offres » n'est pas une des 7 routes de la ressource : on la déclare à la main.
Route::get('mes-offres', [OfferController::class, 'mine'])->name('offres.mine');
Route::resource('offres', OfferController::class)
    ->parameters(['offres' => 'offer']);

// Tous les utilisateurs connectés
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});

// Entreprises et candidats : éditeurs et admins seulement
Route::middleware(['auth', 'verified', 'role:editeur,admin'])->group(function () {
    Route::resource('entreprises', CompanyController::class)
        ->parameters(['entreprises' => 'company']);
    Route::resource('candidats', CandidatController::class);
});

require __DIR__.'/settings.php';