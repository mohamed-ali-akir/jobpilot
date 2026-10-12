<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Company;
use App\Models\Offer;

class OfferController extends Controller
{
    /**
     * Liste des offres.
     */
    public function index()
    {
        // with() : chargement "eager" des entreprises pour éviter une requête par offre
        $offers = Offer::with('company')->withCount('candidats')->latest()->get();

        return view('offres.index', compact('offers'));
    }

    /**
     * Formulaire d'ajout.
     */
    public function create()
    {
        $companies = Company::orderBy('nom')->get();

        return view('offres.create', [
            'companies' => $companies,
            'typesContrat' => Offer::TYPES_CONTRAT,
        ]);
    }

    /**
     * Enregistre une nouvelle offre.
     */
    public function store(StoreOfferRequest $request)
    {
        Offer::create($request->validated());

        return redirect()
            ->route('offres.index')
            ->with('success', 'Offre ajoutée avec succès.');
    }

    /**
     * Détail d'une offre.
     */
    public function show(Offer $offer)
    {
        $offer->load('company', 'candidats');

        return view('offres.show', compact('offer'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Offer $offer)
    {
        $companies = Company::orderBy('nom')->get();

        return view('offres.edit', [
            'offer' => $offer,
            'companies' => $companies,
            'typesContrat' => Offer::TYPES_CONTRAT,
        ]);
    }

    /**
     * Met à jour une offre.
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());

        return redirect()
            ->route('offres.index')
            ->with('success', 'Offre modifiée avec succès.');
    }

    /**
     * Supprime une offre.
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()
            ->route('offres.index')
            ->with('success', 'Offre supprimée avec succès.');
    }
}
