<?php

use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    // Routes REST (index, create, store, show, edit, update, destroy)
    // Noms générés : offres.index, offres.show, entreprises.index, candidats.index, ...
    Route::resource('offres', OfferController::class)
        ->parameters(['offres' => 'offer']);
    Route::resource('entreprises', CompanyController::class)
        ->parameters(['entreprises' => 'company']);
    Route::resource('candidats', CandidatController::class);
});

require __DIR__.'/settings.php';
