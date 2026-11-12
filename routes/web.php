<?php


use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// Accueil : on arrive directement sur la liste des offres (visible même par un invité)
Route::redirect('/', '/offres')->name('home');

// Offres : la protection est dans OfferController (#[Middleware] et #[Authorize]).
// Liste et détail visibles par tout le monde, même un invité.
// « Mes offres » n'est pas une des 7 routes de la ressource : on la déclare à la main.
Route::get('mes-offres', [OfferController::class, 'mine'])->name('offres.mine');
Route::resource('offres', OfferController::class)
    ->parameters(['offres' => 'offer']);
// Candidatures (rôle candidat) : la protection est dans CandidatureController
Route::get('mes-candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
Route::post('offres/{offer}/candidature', [CandidatureController::class, 'store'])->name('candidatures.store');
Route::delete('offres/{offer}/candidature', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');

// Profil : tout utilisateur connecté (matrice : visiteur, éditeur, admin)
Route::middleware('auth')->group(function () {
    Route::get('profil', ProfilController::class)->name('profil');
});

// Tableau de bord : utilisateurs connectés avec e-mail vérifié
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});

// Entreprises et candidats : éditeurs et admins
Route::middleware(['auth', 'verified', 'role:editeur,admin'])->group(function () {
    Route::resource('entreprises', CompanyController::class)
        ->parameters(['entreprises' => 'company']);
    Route::resource('candidats', CandidatController::class);
});

// Espace administration : admin uniquement (middleware role)
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('utilisateurs', [UserController::class, 'index'])->name('users.index');
        Route::patch('utilisateurs/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
    });

require __DIR__.'/settings.php';
