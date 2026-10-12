<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidatRequest;
use App\Http\Requests\UpdateCandidatRequest;
use App\Models\Candidat;
use App\Models\Offer;

class CandidatController extends Controller
{
    /**
     * Liste des candidats.
     */
    public function index()
    {
        $candidats = Candidat::withCount('offers')->orderBy('lastname')->get();

        return view('candidats.index', compact('candidats'));
    }

    /**
     * Formulaire d'ajout.
     */
    public function create()
    {
        $offers = Offer::with('company')->orderBy('name')->get();

        return view('candidats.create', compact('offers'));
    }

    /**
     * Enregistre un nouveau candidat et ses candidatures.
     */
    public function store(StoreCandidatRequest $request)
    {
        $candidat = Candidat::create($request->safe()->only(['firstname', 'lastname']));

        // Relation many-to-many : on enregistre les offres choisies dans la table pivot
        $candidat->offers()->sync($request->input('offers', []));

        return redirect()
            ->route('candidats.index')
            ->with('success', 'Candidat ajouté avec succès.');
    }

    /**
     * Détail d'un candidat avec ses candidatures.
     */
    public function show(Candidat $candidat)
    {
        $candidat->load('offers.company');

        return view('candidats.show', compact('candidat'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Candidat $candidat)
    {
        $offers = Offer::with('company')->orderBy('name')->get();

        return view('candidats.edit', compact('candidat', 'offers'));
    }

    /**
     * Met à jour un candidat et ses candidatures.
     */
    public function update(UpdateCandidatRequest $request, Candidat $candidat)
    {
        $candidat->update($request->safe()->only(['firstname', 'lastname']));
        $candidat->offers()->sync($request->input('offers', []));

        return redirect()
            ->route('candidats.index')
            ->with('success', 'Candidat modifié avec succès.');
    }

    /**
     * Supprime un candidat (ses candidatures sont supprimées en cascade).
     */
    public function destroy(Candidat $candidat)
    {
        $candidat->delete();

        return redirect()
            ->route('candidats.index')
            ->with('success', 'Candidat supprimé avec succès.');
    }
}
