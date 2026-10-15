<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Company;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

// Connexion obligatoire, SAUF pour consulter les offres (liste et détail)
#[Middleware('auth', except: ['index', 'show'])]
#[Middleware('verified', except: ['index', 'show'])]
class OfferController extends Controller
{
    public function index(): View
    {
        $offers = Offer::with('company', 'user')->withCount('candidats')->latest()->get();

        return view('offres.index', ['offers' => $offers, 'titre' => 'Offres d\'emploi']);
    }

    // « Mes offres » : seulement celles de l'utilisateur connecté
    #[Authorize('create', Offer::class)]
    public function mine(Request $request): View
    {
        $offers = $request->user()->offers()
            ->with('company', 'user')->withCount('candidats')->latest()->get();

        return view('offres.index', ['offers' => $offers, 'titre' => 'Mes offres']);
    }

    #[Authorize('create', Offer::class)]
    public function create(): View
    {
        return view('offres.create', [
            'companies' => Company::orderBy('nom')->get(),
            'typesContrat' => Offer::TYPES_CONTRAT,
        ]);
    }

    #[Authorize('create', Offer::class)]
    public function store(OfferRequest $request): RedirectResponse
    {
        // L'auteur = l'utilisateur connecté, jamais une valeur du formulaire
        $request->user()->offers()->create($request->validated());

        return to_route('offres.index')->with('success', 'Offre ajoutée avec succès.');
    }

    public function show(Offer $offer): View
    {
        $offer->load('company', 'user', 'candidats');

        return view('offres.show', compact('offer'));
    }

    #[Authorize('update', 'offer')] // 'offer' = nom du paramètre dans l'URL
    public function edit(Offer $offer): View
    {
        return view('offres.edit', [
            'offer' => $offer,
            'companies' => Company::orderBy('nom')->get(),
            'typesContrat' => Offer::TYPES_CONTRAT,
        ]);
    }

    #[Authorize('update', 'offer')]
    public function update(OfferRequest $request, Offer $offer): RedirectResponse
    {
        $offer->update($request->validated());

        return to_route('offres.index')->with('success', 'Offre modifiée avec succès.');
    }

    #[Authorize('delete', 'offer')]
    public function destroy(Offer $offer): RedirectResponse
    {
        $offer->delete();

        return to_route('offres.index')->with('success', 'Offre supprimée avec succès.');
    }
}